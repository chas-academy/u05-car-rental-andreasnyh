<?php

namespace Main\includes;

class Customers extends Login {
    public function getCustomers() {
        $statement = $this->login()->query("SELECT * FROM Customers");
        /*
        while ($row = $statement->fetchAll()) {

            return($row);
        }
        */
        // Select all the customers in the Customers table

        // Traverse throught the result of the select call, row-by-row
        foreach ($statement as $row) {
            $customerName = htmlspecialchars($row["customerName"]);
            echo $customerName . "<br>";
        }
}
};