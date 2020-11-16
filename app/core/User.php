<?php

namespace App\Core;


use InvalidArgumentException;
use App\Model\UserEntity;


abstract class User
{

	static  bool $logged = false;		
	/**
	 * @var ?string $name
	 * @ORM\Column(length=1)
	 */
	static	?string $name = NULL;
		
	
	public static function setup(): void
    {			
		if (isset($_SESSION['userId']))
			self::loadUser($_SESSION['userId']);
	}


	


	protected static function loadUser(int $userId): void
    {	
		$user = self::getUser($userId, null, null);

		self::$logged 	= true;				
		self::$name		= $user->get("name");				
	}

	/**
	 * Logining user by email and password
	 * @param string $email
	 * @param string password
	 * @return bool
	 */
    public static function login(string $email, string $password): bool
    {				
		// $user must be a object
		if ($user = self::getUser(null, $email, $password)) {	
			if (!$user instanceof UserEntity) 
				return false;
			if (!password_verify($password, $user->get("password")))
				return false;
			self::setupSession($user->get("id"));
			return self::$logged = true;
		}        		

		return self::$logged = false;	
	}

	/**
	 * @uses Session handler
	 */
	private static function setupSession(int $id): void
	{
		$_SESSION['userId'] = $id;
	}

	/**
	 * Static getter for static class property
	 * @throws InvalidArgumentException If the named property does not exists
	 */
    public static function get($name)
    {		
		if (array_key_exists($name, get_class_vars(self::class)))
			return self::$name;
		throw new InvalidArgumentException(
			"The needed variable doese't exist: \"{$name}\"");    
	}
		
	/**	 
	 */
	protected static function getUser(?int $id, ?string $userName, ?string $password): ?UserEntity
	{
		if ($id == null)
			return DB::select(
				"SELECT * FROM `Users` WHERE `name` LIKE :name",
				[
					":name" => $userName,				
				], UserEntity::class
			);		
		
		return DB::select(
			"SELECT * FROM `Users` WHERE `id` = {$id}", [], UserEntity::class);
	}
}