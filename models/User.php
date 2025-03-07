<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $sql = "INSERT INTO personal_data (last_name, first_name, middle_initial, date_of_birth, gender, civil_status, other_civil_status, tax_identification_number, nationality, religion, place_of_birth_city, place_of_birth_province, place_of_birth_country, home_address_city, home_address_province, home_address_country, mobile_number, email_address, telephone_number, father_last_name, father_first_name, father_middle_name, mother_last_name, mother_first_name, mother_middle_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssssssssssssssssssss",
            $data['last_name'], $data['first_name'], $data['middle_initial'], $data['date_of_birth'],
            $data['gender'], $data['civil_status'], $data['other_civil_status'], $data['tax_identification_number'],
            $data['nationality'], $data['religion'], $data['place_of_birth_city'], $data['place_of_birth_province'],
            $data['place_of_birth_country'], $data['home_address_city'], $data['home_address_province'],
            $data['home_address_country'], $data['mobile_number'], $data['email_address'], $data['telephone_number'],
            $data['father_last_name'], $data['father_first_name'], $data['father_middle_name'],
            $data['mother_last_name'], $data['mother_first_name'], $data['mother_middle_name']
        );

        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE personal_data SET last_name=?, first_name=?, middle_initial=?, date_of_birth=?, gender=?, civil_status=?, other_civil_status=?, tax_identification_number=?, nationality=?, religion=?, place_of_birth_city=?, place_of_birth_province=?, place_of_birth_country=?, home_address_city=?, home_address_province=?, home_address_country=?, mobile_number=?, email_address=?, telephone_number=?, father_last_name=?, father_first_name=?, father_middle_name=?, mother_last_name=?, mother_first_name=?, mother_middle_name=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssssssssssssssssssssi",
            $data['last_name'], $data['first_name'], $data ['middle_initial'], $data['date_of_birth'],
            $data['gender'], $data['civil_status'], $data['other_civil_status'], $data['tax_identification_number'],
            $data['nationality'], $data['religion'], $data['place_of_birth_city'], $data['place_of_birth_province'],
            $data['place_of_birth_country'], $data['home_address_city'], $data['home_address_province'],
            $data['home_address_country'], $data['mobile_number'], $data['email_address'], $data['telephone_number'],
            $data['father_last_name'], $data['father_first_name'], $data['father_middle_name'],
            $data['mother_last_name'], $data['mother_first_name'], $data['mother_middle_name'], $id
        );

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM personal_data WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAll() {
        $sql = "SELECT * FROM personal_data";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM personal_data WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>