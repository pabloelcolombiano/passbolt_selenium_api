<?php
/**
 * User fixture.
 *
 * @copyright (c) 2017 Passbolt SARL
 * @licence GNU Affero General Public License http://www.gnu.org/licenses/agpl-3.0.en.html
 */
namespace Data\Fixtures;
use App\Lib\UuidFactory;

class User {

    /**
     * Get a user
     *
     * @throw Exception if gpg can not be found
     * @param $name
     * @return array
     */
    static function get($name) {
        $conf = array(
            'TokenColor' => '#ff3a3a',
            'TokenTextColor' => '#ffffff'
        );
        switch ($name) {
            default:
            case 'ada':
                return array_merge($conf, array(
                    'id' => UuidFactory::uuid('user.id.ada'),
	                'name' => 'ada',
                    'FirstName' => 'Ada',
                    'LastName' => 'Lovelace',
                    'Username' => 'ada@passbolt.com',
                    'MasterPassword' => 'ada@passbolt.com',
                    'TokenCode' => 'ADA',
                    'PrivateKey' => 'ada_private.key',
                    'PublicKey'  => 'ada_public.key',
                ));
                break;
            case 'betty':
                return array_merge($conf, array(
                    'id' => UuidFactory::uuid('user.id.betty'),
	                'name' => 'betty',
                    'FirstName' => 'Betty',
                    'LastName' => 'Holberton',
                    'Username' => 'betty@passbolt.com',
                    'MasterPassword' => 'betty@passbolt.com',
                    'TokenCode' => 'BET',
                    'PrivateKey' => 'betty_private.key'
                ));
                break;
			case 'carol':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.carol'),
					'name' => 'carol',
					'FirstName' => 'Carol',
					'LastName' => 'Shaw',
					'Username' => 'carol@passbolt.com',
					'MasterPassword' => 'carol@passbolt.com',
					'TokenCode' => 'CAR',
					'PrivateKey' => 'carol_private.key'
				));
				break;
			case 'frances':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.frances'),
					'name' => 'frances',
					'FirstName' => 'Frances',
					'LastName' => 'Allen',
					'Username' => 'frances@passbolt.com',
					'MasterPassword' => 'frances@passbolt.com',
					'TokenCode' => 'FRA',
					'PrivateKey' => 'frances_private.key'
				));
				break;
			case 'edith':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.edith'),
					'name' => 'edith',
					'FirstName' => 'Edith',
					'LastName' => 'Clarke',
					'Username' => 'edith@passbolt.com',
					'MasterPassword' => 'edith@passbolt.com',
					'TokenCode' => 'EDI',
					'PrivateKey' => 'edith_private.key'
				));
				break;
			case 'grace':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.grace'),
					'name' => 'grace',
					'FirstName' => 'Grace',
					'LastName' => 'Hopper',
					'Username' => 'grace@passbolt.com',
					'MasterPassword' => 'grace@passbolt.com',
					'TokenCode' => 'GRA',
					'PrivateKey' => 'grace_private.key'
				));
				break;
			case 'irene':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.irene'),
					'name' => 'irene',
					'FirstName' => 'Irene',
					'LastName' => 'Greif',
					'Username' => 'irene@passbolt.com',
					'MasterPassword' => 'irene@passbolt.com',
					'TokenCode' => 'IRN',
					'PrivateKey' => 'irene_private.key'
				));
				break;
			case 'jean':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.jean'),
					'name' => 'jean',
					'FirstName' => 'Jean',
					'LastName' => 'Bartik',
					'Username' => 'jean@passbolt.com',
					'MasterPassword' => 'jean@passbolt.com',
					'TokenCode' => 'JEA',
					'PrivateKey' => 'jean_private.key'
				));
				break;
			case 'orna':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.orna'),
					'name' => 'orna',
					'FirstName' => 'Orna',
					'LastName' => 'Berry',
					'Username' => 'orna@passbolt.com',
					'MasterPassword' => 'orna@passbolt.com',
					'TokenCode' => 'ORA',
					'PrivateKey' => 'orna_private.key'
				));
				break;
			case 'ping':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.ping'),
					'name' => 'ping',
					'FirstName' => 'Ping',
					'LastName' => 'Fu',
					'Username' => 'ping@passbolt.com',
					'MasterPassword' => 'ping@passbolt.com',
					'TokenCode' => 'PNG',
					'PrivateKey' => 'ping_private.key'
				));
				break;
			case 'ruth':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.ruth'),
					'name' => 'ruth',
					'FirstName' => 'Ruth',
					'LastName' => 'Teitelbaum',
					'Username' => 'ruth@passbolt.com',
					'MasterPassword' => 'ruth@passbolt.com',
					'TokenCode' => 'RUT',
					'PrivateKey' => 'ruth_private.key'
				));
				break;
			case 'thelma':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.thelma'),
					'name' => 'thelma',
					'FirstName' => 'Thelma',
					'LastName' => 'Estrin',
					'Username' => 'thelma@passbolt.com',
					'MasterPassword' => 'thelma@passbolt.com',
					'TokenCode' => 'THL',
					'PrivateKey' => 'thelma_private.key'
				));
				break;
			case 'ursula':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.ursula'),
					'name' => 'ursula',
					'FirstName' => 'Ursula',
					'LastName' => 'Martin',
					'Username' => 'ursula@passbolt.com',
					'MasterPassword' => 'ursula@passbolt.com',
					'TokenCode' => 'USL',
					'PrivateKey' => 'ursula_private.key'
				));
				break;
			case 'wang':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('user.id.wang'),
					'name' => 'wang',
					'FirstName' => 'Wang',
					'LastName' => 'Xiaoyun',
					'Username' => 'wang@passbolt.com',
					'MasterPassword' => 'wang@passbolt.com',
					'TokenCode' => 'WNG',
					'PrivateKey' => 'wang_private.key'
				));
				break;
	        case 'kathleen':
		        return array_merge($conf, array(
			        'id' => UuidFactory::uuid('user.id.kathleen'),
			        'name' => 'kathleen',
			        'FirstName' => 'Kathleen',
			        'LastName' => 'Antonelli',
			        'Username' => 'kathleen@passbolt.com',
			        'MasterPassword' => 'kathleen@passbolt.com',
			        'TokenCode' => 'KAT',
			        'PrivateKey' => 'kathleen_private.key',
			        'PublicKey'  => 'kathleen_public.key',
		        ));
		        break;
	        case 'admin':
		        return array_merge($conf, array(
			        'id' => UuidFactory::uuid('user.id.admin'),
			        'name' => 'admin',
			        'FirstName' => 'Admin',
			        'LastName' => 'User',
			        'Username' => 'admin@passbolt.com',
			        'MasterPassword' => 'admin@passbolt.com',
			        'TokenCode' => 'ADM',
			        'PrivateKey' => 'admin_private.key'
		        ));
		        break;

	        /***************************************************
	         *  Definition of non existing users we can
	         *  reuse to create predictive data
	         ***************************************************/

	        case 'john':
		        return array_merge($conf, array(
			        'id' => UuidFactory::uuid('johndoe@passbolt.com'),
			        'name' => 'john',
			        'FirstName' => 'John',
			        'LastName' => 'Doe',
			        'Username' => 'johndoe@passbolt.com',
			        'MasterPassword' => 'johndoe@passbolt.com',
			        'PasswordStrength' => 'strong',
			        'TokenCode' => 'JON',
			        'PrivateKey' => Gpgkey::get(['name' => 'johndoe'])['filepath']
		        ));
		        break;

			case 'curtis':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('curtismayfield@passbolt.com'),
					'name' => 'curtis',
					'FirstName' => 'Curtis',
					'LastName' => 'Mayfield',
					'Username' => 'curtis@passbolt.com',
					'MasterPassword' => 'curtismayfield@passbolt.com',
					'PasswordStrength' => 'very strong',
					'TokenCode' => 'CUR',
					'PrivateKey' => Gpgkey::get(['name' => 'johndoe'])['filepath']
				));
				break;

			case 'chien-shiung':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('chien-shiung@passbolt.com'),
					'name' => 'curtis',
					'FirstName' => 'Chien-Shiung',
					'LastName' => 'Wu',
					'Username' => 'chien-shiung@passbolt.com',
					'MasterPassword' => 'chien-shiung@passbolt.com',
					'PasswordStrength' => 'very strong',
					'TokenCode' => 'CHN',
					'PrivateKey' => Gpgkey::get(['name' => 'chien-shiung'])['filepath']
				));
				break;

			case 'margaret':
				return array_merge($conf, array(
					'id' => UuidFactory::uuid('margaret@passbolt.com'),
					'name' => 'margaret',
					'FirstName' => 'Margaret',
					'LastName' => 'Hamilton',
					'Username' => 'margaret@passbolt.com',
					'MasterPassword' => 'margaret@passbolt.com',
					'PasswordStrength' => 'very strong',
					'TokenCode' => 'MHH',
					'PrivateKey' => Gpgkey::get(['name' => 'margaret'])['filepath']
				));
				break;
        }
    }
}
