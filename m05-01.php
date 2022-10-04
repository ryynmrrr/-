<!DOCTYPE html>
<html lang ="ja">
    <head>
        <meta carset ="UTF-8">
        
        <title>mission5-1</title>
        
    </head>
    <style>
    .forms{
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
    }
    input{
        margin-bottom:10px;
    }
        
    </style>  
    <?php
    
        $dsn = 'mysql:dbname=***;host=localhost';
        $user = '***';
        $password = '***';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        
        $sql = "CREATE TABLE IF NOT EXISTS M_05_01"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "pass INT,"
        . "date INT"
        .");";
        $stmt = $pdo->query($sql);
        
        
        $sql = $pdo -> prepare("INSERT INTO M_05_01 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");        //編集工程１
        $editname="";
        $editcomment="";  
        $editid ="";
        $editpass="";
 
        
        if(!empty($_POST["editid"])&&!empty($_POST["editpass"])){
        $editid =$_POST["editid"];
        $editpassb =$_POST["editpass"];
        
        $sql ='SELECT * from M_05_01 where id=:id && pass=:pass';   
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        foreach ($results as $row){   
            $editid = $row['id'];
            $editpass = $row['pass'];
            $editname = $row['name'];
            $editcomment = $row['comment'];
            
        }
    }
    ?>
    <body>
    <h2> 好きなお笑い芸人は？ </h2>
    <div class ="forms">
        入力
        <form action="" method="post">
            <input type="text" value="<?php echo $editname;?>" name="name" placeholder="名前" >
            <input type="text" value="<?php echo $editcomment;?>" name="comment" placeholder ="コメント" >
            <input type="hidden" value="<?php echo$editid;?>" name="editid" placeholder ="編集番号">
            <input type="number" value="<?php echo$editpass;?>" name ="pass" placeholder="パスワード">
            <input type="submit" name="submit">
        </form>
        削除
        <form action="" method="post">
           <input type= "number" name="deleteid" placeholder="削除する番号">
           <input type="number" name="deletepass" placeholder="パスワード">
           <input type="submit" name = "submit"  value="削除">
        </form>
        編集
        <form action="" method="post">
            <input type="number"name="editid" placeholder="編集する番号">
            <input type ="number" name="editpass" placeholder="パスワード">
            <input type="submit" name="submit" value="編集">
        </form>
    </div>

    <?php
        
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["editid"])){
            
            $name = $_POST["name"];
            $comment =$_POST["comment"]; 
            $date = date("Y/m/d H:i:s");       
            $pass = $_POST["pass"];
            
            
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass, PDO::PARAM_INT);
            $sql -> execute();
            
            
            $sql = 'SELECT * FROM M_05_01';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){      
                
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            }
        }
        
        elseif(!empty($_POST["deleteid"]) && !empty($_POST["deletepass"])){
            $id =$_POST["deleteid"];
            $pass = $_POST["deletepass"];
        
            $sql ='delete from M_05_01 where id=:id && pass=:pass';   
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
            $stmt->execute();
            
            
            $sql = 'SELECT * FROM M_05_01';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){      
                
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            } 
        }
        
        
        elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["editid"])){
                $id =$_POST["editid"]; 
                $pass =$_POST["pass"];
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                
                $sql = 'UPDATE M_05_01 SET name=:name,comment=:comment,pass=:pass WHERE id=:id && pass=:pass';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
                $stmt->execute();
                
        
            $sql = 'SELECT * FROM M_05_01';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){ 
                
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            }  
        }
        
    
    
    else{
        
        $sql = 'SELECT * FROM M_05_01';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){ 
            
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
        }         
    }
    
    ?>    
    </body>
</html>