<?php declare(strict_types=1);
/*
** Zabbix
** Copyright (C) 2001-2022 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


class CControllerTokenCreate extends CController {

	protected function checkInput() {
		$fields = [
			'name'          => 'db token.name|required|not_empty',
			'description'   => 'db token.description',
			'userid'        => 'db users.userid|required',
			'expires_state' => 'in 0,1|required',
			'expires_at'    => 'range_time',
			'status'        => 'db token.status|required|in '.ZBX_AUTH_TOKEN_ENABLED.','.ZBX_AUTH_TOKEN_DISABLED,
			'action_src'    => 'fatal|required|in token.edit,user.token.edit',
			'action_dst'    => 'fatal|required|in token.view,user.token.view'
		];

		$ret = $this->validateInput($fields);

		if (!$ret) {
			switch ($this->getValidationError()) {
				case self::VALIDATION_ERROR:
					$location = (new CUrl('zabbix.php'))->setArgument('action', $this->getInput('action_src'));
					$response = new CControllerResponseRedirect($location);
					$response->setFormData($this->getInputAll());
					CMessageHelper::setErrorTitle(_('Cannot add API token'));
					$this->setResponse($response);
					break;
				case self::VALIDATION_FATAL_ERROR:
					$this->setResponse(new CControllerResponseFatal());
					break;
			}
		}

		return $ret;
	}

	protected function checkPermissions() {
		if (CWebUser::isGuest()) {
			return false;
		}

		return $this->checkAccess(CRoleHelper::ACTIONS_MANAGE_API_TOKENS);
	}

	protected function doAction() {
		$this->getInputs($token, ['name', 'description', 'userid', 'expires_at', 'status']);

		$token['expires_at'] = $this->getInput('expires_state')
			? (new DateTime($token['expires_at']))->getTimestamp()
			: 0;

		$result = API::Token()->create($token);

		if ($result) {
			['tokenids' => $tokenids] = $result;
			[['token' => $auth_token]] = API::Token()->generate($tokenids);

			$response = new CControllerResponseRedirect((new CUrl('zabbix.php'))
				->setArgumentSID()
				->setArgument('action', $this->getInput('action_dst'))
			);

			[$user] = (CWebUser::$data['userid'] != $token['userid'])
				? API::User()->get([
					'output' => ['username', 'name', 'surname'],
					'userids' => $token['userid']
				])
				: [CWebUser::$data];

			$response->setFormData([
				'name' => $token['name'],
				'user' => getUserFullname($user),
				'auth_token' => $auth_token,
				'expires_at' => $token['expires_at'],
				'description' => $token['description'],
				'status' => $token['status']
			]);

			CMessageHelper::setSuccessTitle(_('API token added'));
		}
		else {
			$response = new CControllerResponseRedirect((new CUrl('zabbix.php'))
				->setArgument('action', $this->getInput('action_src'))
			);
			$response->setFormData($this->getInputAll());
			CMessageHelper::setErrorTitle(_('Cannot add API token'));
		}

		$this->setResponse($response);
	}
}
