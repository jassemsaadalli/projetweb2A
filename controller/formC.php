<?php
    include(__DIR__ . '/../config.php');
    include(__DIR__ . '/../model/form.php');
    //include '../view/frontoffice/forgot-password.html';
    class portes
    {
        public function listform()
        {
            $sql="SELECT * FROM portes";
            $db=config::getConnection();
            try
            {
                $liste=$db->query($sql);
                return $liste;
            }
            catch(PDOException $e)
            {
                die("Error: ".$e->getMessage());
            }
        }
        
        public function deleteform($id)
        {
            $sql="DELETE FROM portes WHERE id = :id";
            $db=config::getConnection();
            $req=$db->prepare($sql);
            $req->bindValue(':id',$id);
            try
            {
                $req->execute();
            }
            catch(Exception $e)
            {
                die("Error: ".$e->getMessage());
            }
        }
        public function addform($form) {
            $db = config::getConnection(); // Ensure this returns a valid PDO instance
            try {
                // Prepare the query with backticks for column names
                $query = $db->prepare(
                    "INSERT INTO portes (`nom`, `prenom`, `age`, `num`) 
                     VALUES (:nom, :prenom, :age, :num)"
                );
            
                // Bind parameters to prevent SQL injection
                $query->execute([
                    ':nom' => $form->getNom(),
                    ':prenom' => $form->getPrenom(),
                    ':age' => $form->getAge(),
                    ':num' => $form->getNum(),
                ]);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage(); // Display detailed error
            }
        }
        
        
        public function updateform($form, $id)
        {
            try
            {
                $db = config::getConnection();
                $query = $db->prepare(
                    "UPDATE portes SET 
                        nom= :nom,
                        prenom= :prenom,
                        age= :age,
                        num= :num
                    WHERE id=:id"
                );
                $query->execute([
                    'id'=>$id,
                    'nom'=>$form->getNom(),
                    'prenom'=>$form->getPrenom(),
                    'age'=>$form->getAge(),
                    'num'=>$form->getNum()
                ]);
                echo $query->rowCount()."records UPDATED successfully <br>";
            }
            catch(PDOException $e)
            {
                echo "Error: ".$e->getMessage();
            }
        }
    }
?>