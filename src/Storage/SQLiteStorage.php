<?php

namespace Glfromd\Storage;

use Glfromd\Model\Address;

/**
 * SQLite storage.
 */
class SQLiteStorage
{
	private \PDO $pdo;
	private Address $address;


	public function __construct(string $path)
	{
		if (!is_file($path)) {
			die('Error connecting to sqlite db');
		}

		$this->pdo = new \PDO('sqlite:' . $path);
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->address = new Address();

	}

	/**
     * Read first address row.
     *
     * @return Address|null
     */
	public function readOne(): ?Address
	{
		$stmt = $this->pdo->prepare('SELECT * FROM addresses LIMIT 1');
		$stmt->execute();
		if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			return null;
		}

		return setAddress($row);
	}

	/**
     * Read first address row.
     *
     * @return Address|null
     */
	public function readRandomOne(): ?Address
	{
		$stmt = $this->pdo->prepare('SELECT * FROM addresses ORDER BY RANDOM() LIMIT 1');
		$stmt->execute();
		if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			return null;
		}

		return $this->setAddress($row);
	}

	/**
     * create Address object.
     *
	 * @param array
     * @return Address|null
     */
	private function setAddress($values) : ?Address {
		isset($values['firstname']) ? $this->address->setFirstname($values['firstname']) : $this->address->setFirstname('');
		isset($values['lastname']) ? $this->address->setLastname($values['lastname']) : $this->address->setLastname('');
		isset($values['company_name']) ? $this->address->setCompanyName($values['company_name']) : $this->address->setCompanyName('');
		isset($values['street_address_1']) ? $this->address->setStreetAddress1($values['street_address_1']) : $this->address->setStreetAddress1('');
		isset($values['street_address_2']) ? $this->address->setStreetAddress2($values['street_address_2']) : $this->address->setStreetAddress2('');
		isset($values['city']) ? $this->address->setCity($values['city']) : $this->address->setCity('');
		isset($values['state']) ? $this->address->setState($values['state']) : $this->address->setState('');
		isset($values['zip']) ? $this->address->setZip($values['zip']) : $this->address->setZip('');
		isset($values['country']) ? $this->address->setCountry($values['country']) : $this->address->setCountry('');
		isset($values['phone']) ? $this->address->setPhone($values['phone']) : $this->address->setPhone('');
		isset($values['email']) ? $this->address->setEmail($values['email']) : $this->address->setEmail('');

		return $this->address;
	}


	// public function bulkRead(array $keys): array
	// {
	// 	$stmt = $this->pdo->prepare('SELECT key, data, slide FROM cache WHERE key IN (?' . str_repeat(',?', count($keys) - 1) . ') AND (expire IS NULL OR expire >= ?)');
	// 	$stmt->execute(array_merge($keys, [time()]));
	// 	$result = [];
	// 	$updateSlide = [];
	// 	foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
	// 		if ($row['slide'] !== null) {
	// 			$updateSlide[] = $row['key'];
	// 		}
	// 		$result[$row['key']] = unserialize($row['data']);
	// 	}
	// 	if (!empty($updateSlide)) {
	// 		$stmt = $this->pdo->prepare('UPDATE cache SET expire = ? + slide WHERE key IN(?' . str_repeat(',?', count($updateSlide) - 1) . ')');
	// 		$stmt->execute(array_merge([time()], $updateSlide));
	// 	}
	// 	return $result;
	// }
}
