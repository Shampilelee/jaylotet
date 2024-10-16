
<?php
    include("database.php");

    // FIND
    $message = "";
    $find_Txt = trim(filter_input(INPUT_POST, "find_Txt", FILTER_SANITIZE_SPECIAL_CHARS));

    $itm_nm = '';
    $itm_ct = '';
    $itm_qt = '';
    $tran_Msg = null;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

        // FIND
        if (isset($_POST['find_Btn'])) {
            
            # THIS IS THE SQL QEURY TO RETRIVE ALL DATA IN A ROW THAT, 
            # THE '$username' ENTERED BY THE USER MATCHES WHAT IS IN THE 'username' OF THAT ROW IN MySQL.
            $sql_code = "SELECT * FROM `items` WHERE item_name = '$find_Txt'";
            
            # EXECUTE CODE AND STORE RESULTS IN '$get_ID'
            $get_ID = mysqli_query($conn, $sql_code);
            
            # CHECKING IF '$username' ENTERED BY USER HAS AN ID,
            # IF YES THEN THE USERNAME IS VALID(IN OUR DATABASE).
            if (mysqli_num_rows($get_ID) > 0) {
                
                # FETCH ALL DATA IN ROW FROM '$get_ID' IN STORE IT IN '$row'
                $row = mysqli_fetch_assoc($get_ID);
                // $message = "item name = " .$row["item_name"] . "<br>" . "item cost = ".$row["item_cost"]  . "<br>" . "item category = ".$row["item_category"];
                $itm_nm = $row["item_name"];
                $itm_ct = $row["item_cost"];
                $itm_qt = $row["item_quantity"];

            }
            else{
                //$message = "Sorry, Item Not In Our Database";
                $itm_nm = 'NO DATA';
                $itm_ct = 'NO DATA';
                $itm_qt = 'NO DATA';
            }

            
        }



        // ADD
        if (isset($_POST['add_Btn'])) {

            $item_name = trim(filter_input(INPUT_POST, "item_name", FILTER_SANITIZE_SPECIAL_CHARS));
            $item_cost = filter_input(INPUT_POST, "item_cost", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $item_quantity = filter_input(INPUT_POST, "item_quantity", FILTER_SANITIZE_NUMBER_INT);
            $item_category = filter_input(INPUT_POST, "item_category", FILTER_SANITIZE_SPECIAL_CHARS);
            $item_type = filter_input(INPUT_POST, "item_type", FILTER_SANITIZE_SPECIAL_CHARS);
            # $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS);

            # strpos() CHECKS IF SOMETHING CONTAINS SOMETHING.
            if (strpos($item_cost, ".")) {

                # MAKE SURE IT'S A FLOAT
                $item__cost = floatval($item_cost);

                
                if ($item_name && $item__cost !== false && $item_category) {
                    $sql_code = "INSERT INTO `items` (item_name, item_cost, item_quantity, item_type, item_category, user)
                                VALUES ('$item_name', '$item__cost', '$item_quantity', '$item_type', '$item_category', 'DHOPE')";
        
                    try {
                        mysqli_query($conn, $sql_code);
                        $message = "Item Registered!";
                    } catch (mysqli_sql_exception $e) {
                        $message = "You have a problem adding product: " . $e->getMessage();
                    }
                } else {
                    $message = "Please fill in all fields correctly.";
                }

            } else {
                $message = "item cost MUST BE FLOAT";
            }
            
        } else {
            $message = "fill form";
        }



        // TRANSACTION
        if (isset($_POST['tran_Btn'])) {

            $item_name = trim(filter_input(INPUT_POST, "tran_Txt", FILTER_SANITIZE_SPECIAL_CHARS));
            $tran_Cost = filter_input(INPUT_POST, "tran_Cost", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
            $tran_quantity = filter_input(INPUT_POST, "tran_Qty", FILTER_SANITIZE_NUMBER_INT);
            $tran_Day = trim(filter_input(INPUT_POST, "tran_Day", FILTER_SANITIZE_SPECIAL_CHARS));
            
            # strpos() CHECKS IF SOMETHING CONTAINS SOMETHING.
            if (strpos($tran_Cost, ".")) {
    
                # MAKE SURE IT'S A FLOAT
                $tran__Cost = floatval($tran_Cost);
                
                if ($item_name && $tran__Cost !== false && $tran_quantity) {
                    
                    $paid = $tran__Cost * $tran_quantity;
                    $sql_code = "INSERT INTO `transactions` (item_sold, item_cost, quantity_sold, customer_piad, day_Sold)
                                 VALUES ('$item_name', '$tran__Cost', '$tran_quantity', '$paid', '$tran_Day')";
        
                    try {
                        mysqli_query($conn, $sql_code);
                        $message = "Transaction Registered!";
                    } catch (mysqli_sql_exception $e) {
                        $message = "You have a problem adding transaction: " . $e->getMessage();
                    }
                } else {
                    $message = "Please fill in all fields correctly.";
                }
    
            } else {
                $message = "item cost MUST BE FLOAT";
            }
            
        } else {
            $message = "fill form";
        }



        // UPDATE
        if (isset($_POST['update_Btn'])) {
        
            $item_name = trim(filter_input(INPUT_POST, "update_Name", FILTER_SANITIZE_SPECIAL_CHARS));
            $usr_chose = filter_input(INPUT_POST, "usr_chose", FILTER_SANITIZE_SPECIAL_CHARS);
            $usr_chg = trim(filter_input(INPUT_POST, "usr_chg", FILTER_SANITIZE_SPECIAL_CHARS));
    
            
            $sql_code = "SELECT * FROM `items` WHERE item_name = '$item_name' ";
            $get_ID = mysqli_query($conn, $sql_code);
    
    
            if (mysqli_num_rows($get_ID) > 0) {
                
                $row = mysqli_fetch_assoc($get_ID);
            
                $id = $row["item_id"];
    
                if ($row["item_name"] == $item_name) {
                    $sql_code_update_item = "UPDATE `items` SET `$usr_chose` = '$usr_chg' WHERE `items`.`item_id` = $id";
                    mysqli_query($conn, $sql_code_update_item);
                    $message = "$usr_chose UPDATED. ";
                }
                
            }
            else{
                $message = "Item Name Not in Our Database";
            }
    
        }

    }



    // LAST TRANSACTION
    $sql_code = "SELECT * FROM `transactions` ORDER BY transaction_id DESC LIMIT 1 ";
    $get_ID = mysqli_query($conn, $sql_code);

    if (mysqli_num_rows($get_ID) > 0) {
        
        $row = mysqli_fetch_assoc($get_ID);
    
        $pd_Name = $row["item_sold"];
        $pd_Price = $row["customer_piad"];
        
    }
    else{
        $pd_Name = "No Transaction";
    }



    // BIGEST SELL OF ALL TIME BY QUANTITY
    $sql = "
        SELECT item_sold, SUM(quantity_sold) AS total_quantity
        FROM transactions
        GROUP BY item_sold
        ORDER BY total_quantity DESC
        LIMIT 1;
    ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        
        $data = mysqli_fetch_assoc($result);
        $big_Sell_ByQuan = $data["item_sold"];
        $big_Sell = $data["total_quantity"];
        
    } else {
        $big_Sell_ByQuan = 'no data';
    }



    // SELLS PER WEEK, DIPLAY THE LAST RECENT DATA
    $wek_sql = "
        SELECT 
            DATE_FORMAT(MIN(day_Sold), '%d-%m-%y') AS week_start,
            DATE_FORMAT(MAX(day_Sold), '%d-%m-%y') AS week_end,
            SUM(quantity_Sold) AS total_sold
        FROM transactions
        GROUP BY WEEK(day_Sold)
        ORDER BY day_Sold DESC 
        LIMIT 1;
    ";

    $wek_Result = mysqli_query($conn, $wek_sql);

    if (mysqli_num_rows($wek_Result) > 0) {
        
        $wek_data = mysqli_fetch_assoc($wek_Result);

        $wek_day = $wek_data["week_start"] . ' to ' . $wek_data["week_end"];
        $wek_sells = $wek_data["total_sold"];
        
    } else {
        $big_Sell_ByQuan = 'no data';
    }



    // SELLS PER MONTH, DIPLAY THE LAST RECENT DATA
    $mon_sql = "
        SELECT 
            DATE_FORMAT(MIN(day_Sold), '%d-%m-%y') AS month_start,
            DATE_FORMAT(MAX(day_Sold), '%d-%m-%y') AS month_end,
            SUM(quantity_Sold) AS total_sold
        FROM transactions
        GROUP BY YEAR(day_Sold), MONTH(day_Sold)
        ORDER BY MAX(day_Sold) DESC
        LIMIT 1;
    ";

    $mon_Result = mysqli_query($conn, $mon_sql);

    if (mysqli_num_rows($mon_Result) > 0) {
        
        $mon_data = mysqli_fetch_assoc($mon_Result);

        $month = $mon_data["month_start"] . ' to ' . $mon_data["month_end"];
        $mon_sells = $mon_data["total_sold"];
        
    } else {
        $mon_data = 'no data';
    }


    


?>


<!-- <style>
    /* Add this to your style.css */
    #suggestions {
        border: 1px solid #ccc;
        max-height: 150px;
        /* overflow-y: auto; */
        list-style-type: none;
        padding: .2em;
        margin: 0;
        /* position: absolute; */
        width: 18vw;
        background-color: grey;
        color: white;
    }

    #suggestions li {
        padding: 10px;
        cursor: pointer;
    }

    #suggestions li:hover {
        background-color: #eee;
        color: black;
    }
</style> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/scss/style.css">
    <title>JAYLOTET COSMETICE</title>
</head>
<body>
    <header>
        <div class="menu">
            <div class="logo">J-LOY</div>
    
            <div class="nav">
                <a href="#pg1">FIND</a>
                <a href="#pg2">ADD</a>
                <a href="#pg3">TRANS</a>
                <a href="#pg4">UPDATE</a>
                <a href="#pg5">STAT</a>
            </div>
        </div>
    
        <div class="welcome_Pg">
            <div class="txt">

                <h1>Jaylotet Cosmetice</h1>
                
                <h3>& more!</h3>

                <div class="desc">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem at asperiores repellendus laboriosam accusantium accusamus incidunt repudiandae tempora, porro animi autem veniam ratione doloremque aperiam adipisci iusto iste dignissimos ipsam!
                </div>

            </div>
        </div>
    </header>
    


    <main>
        <div class="page find" id="pg1">
            <h1>FIND <span>PRODUCT</span></h1>
    
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="search" name="find_Txt" id="find_Txt" required>
                <input type="submit" name="find_Btn" id="find_Btn">
            </form>
            <ul id="suggestions"></ul>

            <div class="found">
                <div class="itm name"> 
                    <div class="pt">Name:</div>
                    <div class="result"><?php echo $itm_nm ?></div>
                </div>

                <div class="itm price">
                    <div class="pt">Price:</div>
                    <div class="result"><?php echo $itm_ct ?></div>
                </div>

                <div class="itm qty">
                    <div class="pt">Quantity:</div>
                    <div class="result"><?php echo $itm_qt ?></div>
                </div>
            </div>
        </div>

        <div class="page add" id="pg2">
            <h1>ADD <span>ITEM</span></h1>

            <?php echo $message ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Item Name" name="item_name" required>

                <div class="num">
                    <input type="number" name="item_cost" id="" step="0.01" placeholder="Item Price" required>
                    <input type="number" name="item_quantity" id="" placeholder="Item Quantity" required>
                </div>

                <select id="item_type" name="item_type" placeholder="type" required>
                    <option value="">Item Type</option>
                    <option value="Hair">Hair</option>
                    <option value="Perfume">Perfume</option>

                    <option value="Cream">Cream</option>
                    <option value="Oil">Oil</option>
                    <option value="Cleaner"> CLEANER</option>
                    <option value="Hair Dye">Hair Dye</option>
                    <option value="Hair Spray">Hair Spray</option>
                    <option value="Hair Relaxer">Hair Relaxer</option>
                    <option value="Hair WAX / GEL">Hair WAX / GEL</option>
                    <option value="Shower Gel">Shower Gel</option>
                    <option value="Concentrated Serum">Concentrated Serum</option>
                    <option value="Sun Block C">Sun Block C</option>
                    <option value="Soap">Soap</option>
                    <option value="Powder">Powder</option>
                    <option value="Shampoo / Conditioner">Shampoo / Conditioner</option>
                    <option value="Pain Releaver">Pain Releaver</option>
                    <option value="Body Repair">Body Repair</option>
                    <option value="Eye Lashes">Eye Lashes</option>
                    <option value="NAIL">NAIL</option>
                    <option value="Singlet">Singlet</option>
                    <option value="Boxer">Boxer</option>
                    <option value="Tools">Tools</option>
                </select>

                <label for="category" id="show_catgory_lbel">Category</label>
                <div id="choices">
                    <select id="hair" name="item_category" required>
                        <option value="">select</option>
                        <option value="Braid">Braid</option>
                        <option value="Lydia">Lydia</option>
                        <option value="Pony">Pony</option>
                        <option value="Twist">Twist</option>
                        <option value="Dread">Dread</option>
                        <option value="Locs">Locs</option>
                        <option value="Kinky">Kinky</option>
                        <option value="Bundle Hair">Bundle Hair</option>
                        <option value="Hair Wool">Hair Wool</option>
                        <option value="Hair NETS">Hair NETS</option>
                    </select>

                    <select id="spray" name="item_category" required>
                        <option value="">select</option>
                        <option value="Body Splash">body splash</option>
                        <option value="Deodorant">deo-dorant</option>
                        <option value="SURE">SURE</option>
                        <option value="Body Spray">body-spray</option>
                        <option value="Spray">Spray</option>
                    </select>

                    <select id="cream" name="item_category" required>
                        <option value="">select</option>
                        <option value="Body Cream">Body Cream</option>
                        <option value="Body Lotion">Body Lotion</option>
                        <option value="Facial Cream">Facial Cream</option>
                        <option value="Body and Facial Cream">Body & Facial Cream</option>
                        <option value="Hair Cream">Hair Cream</option>
                    </select>

                    <select id="oil" name="item_category" required>
                        <option value="">select</option>
                        <option value="Baby Oil">Baby Oil</option>
                        <option value="Body and Face Oil">Body & Face Oil</option>
                    </select>

                    <select id="others" name="item_category" required>
                        <option value="">select</option>
                        <option value="...">empty space</option>
                    </select>
                </div>

                <input type="reset" value="Reset">
                <input type="submit" value="Add" name="add_Btn">
            </form>
        </div>

        <div class="page trans" id="pg3">
            <h1>TRANSACTIONS</h1>
            <?php echo $message ?>

            <form action="" method="post">
                <input type="text" name="tran_Txt" placeholder="Item Name" required>
                
                <div class="cost">
                    <input type="number" name="tran_Cost" id="" step="0.01" placeholder="Item Price" required>
                    <input type="number" name="tran_Qty" id="" placeholder="Item Quantity" required>
                </div>
                
                <input type="date" name="tran_Day" id="" required>
                <input type="reset" value="Reset">
                <input type="submit" value="Add" name="tran_Btn">
            </form>
        </div>

        <div class="page update" id="pg4">
            <h1>UPDATE</h1>

            <?php echo $message ?>

            <form action="" method="post">
                <input type="text" placeholder="Item Name" name="update_Name" required>
                
                <!-- <div class="cost">
                    <input type="number" name="" id="" step="0.01" placeholder="NEW Item Price" >
                    <input type="number" name="" id="" placeholder="NEW Item Quantity" >
                </div>

                <input type="text" placeholder="NEW Item Name" required> -->

                <div class="chose">
                    <div class="box">
                        <label for="cost">Cost</label>
                        <input type="radio" name="usr_chose" id="cost" value="item_cost" required>
                    </div>

                    <div class="box">
                        <label for="quantity">Quantity</label>
                        <input type="radio" name="usr_chose" id="quantity" value="item_quantity">
                    </div>

                    <div class="box">
                        <label for="type">Type</label>
                        <input type="radio" name="usr_chose" id="type" value="item_type">
                    </div>

                    <div class="box">
                        <label for="category">Category</label>
                        <input type="radio" name="usr_chose" id="category" value="item_category">
                    </div>
                </div>
                
                
                <input type="text" name="usr_chg" placeholder="Enter Change Here" minlength="3" maxlength="50" required>

                <input type="reset" value="Reset">
                <input type="submit" value="Modify" name="update_Btn">
            </form>
        </div>

        <div class="page stat" id="pg5">
            <h1>STATISTICES / INFO SYSTEM</h1>

            <div class="info">
                <div class="data last_Trans">
                    <div class="prompt">
                        Last Transaction
                    </div>

                    <div class="results">
                        <div class="product_Name">
                            <?php echo $pd_Name ?>
                        </div>

                        <div class="paid">
                            <!-- ¢100 -->
                            ¢<?php echo $pd_Price ?>
                        </div>
                    </div>
                </div>

                <div class="data biggest_sell_byQan">
                    <div class="prompt">
                        Most Sold Product By Qantity
                    </div>
                    
                    <div class="results">
                        <div class="product_Name">
                            <?php echo $big_Sell_ByQuan ?>
                        </div>

                        <?php echo $big_Sell ?>
                    </div>
                </div>

                <div class="data weekly_sells">
                    <div class="prompt">
                        Number Of Sold Product Per Week
                    </div>

                    <div class="results">
                        <div class="week">
                            <?php echo $wek_day ?>
                        </div>
                        
                        <?php echo $wek_sells ?>
                    </div>
                </div>

                <div class="data monthly_sells">
                    <div class="prompt">
                        Number Of Sold Product Per Month
                    </div>
                    
                    <div class="results">
                        <div class="month">
                            <?php echo $month ?>
                        </div>

                        <?php echo $mon_sells ?>
                    </div>
                </div>
            </div>
        
        </div>
    </main>
    


    <footer>
        <div class="copy_Rig">copyright reserved</div>
        <div id="year"></div>
    </footer>

    <script src="main.js"></script>
</body>
</html>



<?php

    # CLOSING CONNECTION
    try {
        if ($conn instanceof mysqli) {
            mysqli_close($conn);
            //$message = "<br> Database Connected ☁";
        } else {
            throw new Exception("<br> You're Not Connected To Database. Please try again later.");
        }
    } catch (Exception $e) {
       // $message = $e->getMessage();
    }
?>



