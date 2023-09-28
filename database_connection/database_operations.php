<?php 
    class database_operations {
        private $connection;

        //creating a database connection
        function __construct() {
            $this->connection = new PDO("mysql:host=localhost;dbname=pranav_kolharkar","pranav_kolharkar","deep70");
        }

        //executing select query to fetch data
        public function selectData($tableName,$fetchColumns="*",$joinQuery="",$whereQuery="",$orderByQuery="") {
            $selectQuery = "select {$fetchColumns} from {$tableName}"; //actual query
            if($joinQuery != "") {
                $selectQuery.=" ".$joinQuery; //appending join query if any
            }
            if($whereQuery != "") {
                $selectQuery.=" ".$whereQuery; //appending where query if any
            }
            if($orderByQuery != "") {
                $selectQuery.=" ".$orderByQuery; //appending order by query if any
            }
            $statement = $this->connection->prepare($selectQuery);
            $statement->execute();
            $result = $statement->fetchAll(); //get result set
            return $result; //return result set
        }

        public function insertData($tableName,$data) {
            //declaring keys & value array
            $columnName = array();
            $columnValues = array();
            foreach($data as $key=>$value) {
                //diving data to key and value and pushing it to their arrays
                array_push($columnName,$key);
                array_push($columnValues,":".$key." ");
            }

            //imploding both the arrays
            $columnName = implode(",",$columnName);
            $columnValues = implode(",",$columnValues);
            
            //insert into the table 
            $insertQuery = "insert into $tableName ($columnName) values ($columnValues)";
            $statement = $this->connection->prepare($insertQuery);

            //binding reference to actual values
            foreach ($data as $key=>$value) {
                $statement->bindParam(":".$key,$data[$key]);
            }
            $statement->execute();
        }

        //executing delete query to delete any record
        public function deleteData($tableName,$id,$columnName) {
            $deleteQuery = "delete from {$tableName} where $columnName=:"."$columnName";
            $statement = $this->connection->prepare($deleteQuery);
            //bind parameters to query
            $statement->bindParam(":".$columnName,$id,PDO::PARAM_INT);
            $statement->execute();
        }

        public function updateData($tableName,$data,$where) {

            //declaring array which contains data to be updated in table
            $result = array();
            foreach(array_keys($data) as $key) {

                //pushing data to array
                array_push($result,$key."=:".$key." ");
            }

            //imploding the array
            $result = implode(',',$result);

            //update the data
            $updateQuery = "update {$tableName} set {$result} where {$where}";

            $statement = $this->connection->prepare($updateQuery);
            foreach($data as $key=>$value) {

                //binding reference to actual values
                $statement->bindParam(":".$key,$data[$key]);
            }
            $statement->execute();
        }
    }
?>
