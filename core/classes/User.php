<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use Cloudinary\Api\Upload\UploadApi;
    use Cloudinary\Configuration\Configuration;

    Configuration::instance([
         'cloud' => [
              'cloud_name' => 'dodl3q3vr',
              'api_key'    => '897453696266978',
              'api_secret' => '9c5IusyEnZqtWY3o-9eYoJCTKc8', #adoxzy89@gmail.com
         ],
         'url' => [
             'secure' => true
         ]
    ]);
    
    // 'cloud_name' => 'do9whlpl9',
    // 'api_key'    => '684742122187765',
    // 'api_secret' => 'zCVPdGhBaGktyG8k9UYxhC74Nbg',

    class User {
        protected $pdo, $currencySymbols;
        private $cloudName = 'dodl3q3vr';
        private $apiKey = '897453696266978';
        private $apiSecret = '9c5IusyEnZqtWY3o-9eYoJCTKc8'; #
        
        /** @var string optional logger callback */
        protected $loggerCallback = null;

        function __construct($pdo) {
            $this->pdo = $pdo;
            $this->currencySymbols = [
                'NGN' => '₦',
                'USD' => '$',
                'EUR' => '€',
                'GBP' => '£',
                'JPY' => '¥',
                'INR' => '₹',
                'CAD' => 'C$',
                'AUD' => 'A$',
                'ZAR' => 'R',
                'CHF' => '₣'
           ];
        }

        public function checkInput($var) {
            $var = htmlspecialchars($var);
            $var = trim($var);
            $var = stripcslashes($var);
            return $var;
        }

        public function createSlug($varName) {
            $varSlug = strtolower($varName);
            $varSlug = str_replace(' ', '-', $varSlug);
            return $varSlug;
        }

        protected function log(string $msg)
        {
            if ($this->loggerCallback) {
                call_user_func($this->loggerCallback, $msg);
            } else {
                // fallback: write to error_log
                error_log($msg);
            }
        }


        /**
         * Begin a DB transaction.
         * Returns true on success, false on failure.
         * Throws an exception on fatal error.
         */
        public function beginTransaction(): bool
        {
            try {
                if ($this->pdo instanceof \PDO) {
                    // PDO returns true/false
                    $ok = $this->pdo->beginTransaction();
                    if (!$ok) {
                        $this->log('Failed to begin PDO transaction.');
                    }
                    return (bool)$ok;
                }

                if ($this->pdo instanceof \mysqli) {
                    // mysqli returns true/false; begin_transaction exists in newer PHP
                    if (method_exists($this->pdo, 'begin_transaction')) {
                        $ok = $this->pdo->begin_transaction();
                    } else {
                        // fallback to autocommit(false)
                        $ok = $this->pdo->autocommit(false);
                    }
                    if (!$ok) {
                        $this->log('Failed to begin mysqli transaction: ' . $this->pdo->error);
                    }
                    return (bool)$ok;
                }

                $this->log('No DB connection available to begin transaction.');
                return false;
            } catch (\Throwable $e) {
                $this->log('Exception in beginTransaction: ' . $e->getMessage());
                throw $e;
            }
        }

        /**
         * Commit the current transaction.
         */
        public function commit(): bool
        {
            try {
                if ($this->pdo instanceof \PDO) {
                    $ok = $this->pdo->commit();
                    if (!$ok) $this->log('PDO commit returned false.');
                    return (bool)$ok;
                }

                if ($this->pdo instanceof \mysqli) {
                    if (method_exists($this->pdo, 'commit')) {
                        $ok = $this->pdo->commit();
                    } else {
                        // fallback to autocommit(true)
                        $ok = $this->pdo->autocommit(true);
                    }
                    if (!$ok) {
                        $this->log('mysqli commit failed: ' . $this->pdo->error);
                    }
                    return (bool)$ok;
                }

                $this->log('No DB connection available to commit transaction.');
                return false;
            } catch (\Throwable $e) {
                $this->log('Exception in commit: ' . $e->getMessage());
                throw $e;
            }
        }

        /**
         * Rollback the current transaction.
         */
        public function rollback(): bool
        {
            try {
                if ($this->pdo instanceof \PDO) {
                    $ok = $this->pdo->rollBack();
                    if (!$ok) $this->log('PDO rollback returned false.');
                    return (bool)$ok;
                }

                if ($this->pdo instanceof \mysqli) {
                    if (method_exists($this->pdo, 'rollback')) {
                        $ok = $this->pdo->rollback();
                    } else {
                        // fallback to autocommit(true) as a try to restore
                        $ok = $this->pdo->autocommit(true);
                    }
                    if (!$ok) {
                        $this->log('mysqli rollback failed: ' . $this->pdo->error);
                    }
                    return (bool)$ok;
                }

                $this->log('No DB connection available to rollback transaction.');
                return false;
            } catch (\Throwable $e) {
                $this->log('Exception in rollback: ' . $e->getMessage());
                throw $e;
            }
        }

        public function login($email, $password) {
            $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `email` = :email AND `password` = :passwords");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":passwords", $password, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

           if($count > 0) {
                if($user->access === 0) {
                    return 'banned';
                } else {
                    $_SESSION['id'] = $user->id;
                    if($user?->status === 'admin') {
                        return 'admin';
                    } else {
                        $routeId = $this->select_one_val('user_pages', 'page_id', 'user_id', $user->id);
                        $routeName = $this->selectOneColumnWithTwoConditions('pages', 'route', 'route', 'nill', 'id', $routeId);
                        return $routeName;
                    }
                }
            } else {
                return false;
            }
        }

        // Function to format amount with currency symbol
        public function formatCurrency($amount, $currencyCode) {
            $symbol = $this->currencySymbols[$currencyCode] ?? $currencyCode; // Use symbol or fallback to code
            return $symbol . number_format($amount, 2, '.', ','); // Format number with 2 decimal places
        }

        public function getCurrencySymbol($currencyCode) {
            return $this->currencySymbols[$currencyCode] ?? $currencyCode; // Use symbol or fallback to code
        }

        public function timeAgo($currentDateTime)
        {
            // Original timestamp
            $originalTimestamp = strtotime($currentDateTime);

            // Current timestamp
            $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

            // Calculate the difference in seconds
            $timeDifference = $currentTimestamp - $originalTimestamp;

            // Create a DateTime object for the difference
            $dateTimeDifference = new DateTime("@$timeDifference");

            // Get the interval in a human-readable format
            $interval = $dateTimeDifference->diff(new DateTime('@0'));
            $timeAgo = $interval->format('%y years, %m months, %d days, %h hours, %i min, %s sec ago');

            return $timeAgo;
        }

        
        public function logout() {
            $_SESSION = array();
            session_destroy();
            header('Location: '.BASE_URL.'login');
        }
        
        // to check/verify whether something is existing in a table with 1 conditions
        public function check_exist_one_col($table, $column, $keyword) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$column` = :keyword");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                return true;
            } else {
                return false;
            }
        }
        
        // to check/verify whether something is existing in a table with 2 conditions
        public function check_exist_two_col($table, $column, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$first_column` = :first_keyword AND `$second_column` = :second_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                return true;
            } else {
                return false;
            }
        }
        

        // selecting all columns and values from table
        public function select_all_val_table($table) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function select_all_val_row($table, $first_column, $first_keyword) {
			$stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$first_column` = :first_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_OBJ);
		}

        public function select_all_val_row_no_cond($table) {
			$stmt = $this->pdo->prepare("SELECT * FROM `$table`");
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_OBJ);
		}

        public function hasAccess($userId, $route) {
            $stmt = $this->pdo->prepare("
                SELECT up.page_id 
                FROM user_pages up
                INNER JOIN pages p ON up.page_id = p.id
                WHERE up.user_id = :userId AND p.route = :route
            ");
            $stmt->execute(['userId' => $userId, 'route' => $route]);
            return $stmt->fetchColumn() !== false; // Returns true if access exists, false otherwise
        }
        

        // selecting all columns and values from table in descending order
        public function select_all_val_table_desc($table) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` ORDER BY `id` DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // selecting all columns and values from table in descending order with branch filter
        public function select_all_val_table_branch_desc($table, $branch_id = null) {
            // Try multiple sources for branch_id
            $branchId = $branch_id ?? $_SESSION['branch_id'] ?? null;
            
            if (!$branchId) {
                // No branch ID, return empty or all? Decide based on your needs
                return $this->pdo->query("SELECT * FROM `$table` ORDER BY `id` DESC")->fetchAll(PDO::FETCH_OBJ);
                // return [];
            }
            
            $query = "SELECT * FROM `$table` WHERE branch_id = :branch_id ORDER BY `id` DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':branch_id', $branchId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        

        // selecting all columns and values from table in descending order limit of 250
        public function select_all_val_table_desc_limit($table) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` ORDER BY `id` DESC LIMIT 250");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // selecting just a value from table with a condition
        public function select_one_val($table, $column, $value, $keyword) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$value` = :keyword");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchcolumn();
        }
        
        // selecting just a value from table with 2 conditions
        public function selectOneColumnWithTwoConditionsNot($table, $column, $firstColumn, $firstValue, $secondColumn, $secondValue) {
            $query = "SELECT `$column` FROM `$table` WHERE `$firstColumn` = :firstValue AND `$secondColumn` = :secondValue";
        
            $stmt = $this->pdo->prepare($query);
        
            // Bind parameters
            $stmt->bindParam(':firstValue', $firstValue, PDO::PARAM_STR);
            $stmt->bindParam(':secondValue', $secondValue, PDO::PARAM_INT);
        
            // Execute query
            $stmt->execute();
        
            // Fetch and return the result
            return $stmt->fetchColumn();
        }
        
        // selecting just a value from table with 2 conditions
        public function selectOneColumnWithTwoConditions($table, $column, $firstColumn, $firstValue, $secondColumn, $secondValue) {
            $query = "SELECT `$column` FROM `$table` WHERE `$firstColumn` != :firstValue AND `$secondColumn` = :secondValue";
        
            $stmt = $this->pdo->prepare($query);
        
            // Bind parameters
            $stmt->bindParam(':firstValue', $firstValue, PDO::PARAM_STR);
            $stmt->bindParam(':secondValue', $secondValue, PDO::PARAM_INT);
        
            // Execute query
            $stmt->execute();
        
            // Fetch and return the result
            return $stmt->fetchColumn();
        }

        // selecting last value from table with a condition
        public function select_last_val($table, $column, $value, $keyword) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$value` = :keyword ORDER BY `id` DESC LIMIT 1");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchcolumn();
        }
        
        // selecting just a value from table with 2 conditions
        public function select_one_val_two_conds($table, $column, $first_value, $first_keyword, $second_value, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$first_value` = :first_keyword AND `$second_value` = :second_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        
        // selecting just a value from table with 2 conditions
        public function select_one_val_two_or_conds($table, $column, $first_value, $first_keyword, $second_value, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$first_value` = :first_keyword OR `$second_value` = :second_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function select_one_value_two_or_conds(string $table, string $column, string $col1, $val1, string $col2, $val2) {
            $sql = "SELECT `$column` FROM `$table` WHERE `$col1` = :v1 OR `$col2` = :v2 LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':v1', $val1, PDO::PARAM_STR);
            $stmt->bindValue(':v2', $val2, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row[$column] : null;
        }

        // Returns associative row (same shape as your other fetchers)
        public function select_one_row_two_or_conds(string $table, string $col1, $val1, string $col2, $val2) {
            $sql = "SELECT * FROM `$table` WHERE `$col1` = :v1 OR `$col2` = :v2 LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':v1', $val1, PDO::PARAM_STR);
            $stmt->bindValue(':v2', $val2, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // null if not found
        }
        
        // selecting all columns and values from table with a condition in ascending order
        public function select_all_one_cond($table, $column, $keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$column` = :keyword");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // selecting all columns and values from table with a condition in descending order
        public function select_all_one_cond_desc($table, $column, $keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$column` = :keyword ORDER BY `id` DESC");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // select all fromk a table with a condition
        public function search_all_one_cond($table, $column, $search) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$column` LIKE ?");
            $stmt->bindValue(1, $search.'%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // selecting all columns and values from table with a condition using OR in ascending order
        public function select_all_two_cond_one_greater($table, $first_column, $first_keyword, $second_column, $second_keyword) {
            $query = "SELECT * FROM `$table` WHERE `$first_column` = :first_keyword AND `$second_column` >= :second_keyword";

            // if (isset($_SESSION['branch_id'])) {
            //     $query .= " WHERE branch_id = :branch_id";
            // }

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);

            // if (isset($_SESSION['branch_id'])) {
            //     $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            // }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // public function count_all_col($table, $column) {
        //     $query = "SELECT COUNT('".$column."') FROM `$table`";
            
        //     // Add branch filter if a branch ID is set in the session
        //     if (isset($_SESSION['branch_id'])) {
        //         $query .= " WHERE branch_id = :branch_id";
        //     }
            
        //     $stmt = $this->pdo->prepare($query);
        //     // var_dump($stmt);

        //     if (isset($_SESSION['branch_id'])) {
        //         $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
        //     }

        //     $stmt->execute();
        //     return $stmt->fetchcolumn();
        // }

        // selecting all columns and values from table with a condition using OR in ascending order
        public function select_all_three_cond_one_greater($table, $first_column, $first_keyword, $second_column, $second_keyword, $third_column, $third_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$first_column` = :first_keyword AND `$second_column` >= :second_keyword AND `$third_column` = :third_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":third_keyword", $third_keyword, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // selecting all columns and values from table with a condition using OR in ascending order
        public function select_all_two_or_cond($table, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$first_column` = :first_keyword OR `$second_column` = :second_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // public function fetch_product_with_market_price($barcode_or_name, $branch_id)
        // {
        //     // First get the product
        //     $product_sql = "SELECT * FROM products 
        //                     WHERE LOWER(name) = LOWER(:barcode_or_name) 
        //                     OR LOWER(code) = LOWER(:barcode_or_name)
        //                     LIMIT 1";
        //     $product_stmt = $this->pdo->prepare($product_sql);
        //     $product_stmt->bindParam(':barcode_or_name', $barcode_or_name, PDO::PARAM_STR);
        //     $product_stmt->execute();
        //     $product = $product_stmt->fetch(PDO::FETCH_OBJ);
            
        //     if (!$product) {
        //         error_log("Product not found: " . $barcode_or_name);
        //         return [];
        //     }
            
        //     // Debug: Check what we found
        //     error_log("Found product: " . json_encode($product));
            
        //     // Then get Wholesale Price - let's try multiple approaches
        //     $market_sql = "SELECT price FROM market_products 
        //                 WHERE branch_id = :branch_id 
        //                 AND (LOWER(name) = LOWER(:name) OR LOWER(code) = LOWER(:code))
        //                 LIMIT 1";
        //     $market_stmt = $this->pdo->prepare($market_sql);
        //     $market_stmt->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
        //     $market_stmt->bindParam(':name', $product->name, PDO::PARAM_STR);
        //     $market_stmt->bindParam(':code', $product->code, PDO::PARAM_STR);
        //     $market_stmt->execute();
            
        //     // Check if query executed successfully
        //     if ($market_stmt === false) {
        //         $error = $this->pdo->errorInfo();
        //         error_log("Wholesale Price query error: " . json_encode($error));
        //         $market_price = false;
        //     } else {
        //         $market_price = $market_stmt->fetch(PDO::FETCH_OBJ);
        //     }
            
        //     // Debug: Check what we found for Wholesale Price
        //     error_log("Wholesale Price result: " . json_encode($market_price));
            
        //     // If no Wholesale Price found, try alternative approaches
        //     if (!$market_price) {
        //         // Try with trimmed values
        //         $trimmed_name = trim($product->name);
        //         $trimmed_code = trim($product->code);
                
        //         $market_sql2 = "SELECT price FROM market_products 
        //                     WHERE branch_id = :branch_id 
        //                     AND (LOWER(name) = LOWER(:name) OR LOWER(code) = LOWER(:code))
        //                     LIMIT 1";
        //         $market_stmt2 = $this->pdo->prepare($market_sql2);
        //         $market_stmt2->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
        //         $market_stmt2->bindParam(':name', $trimmed_name, PDO::PARAM_STR);
        //         $market_stmt2->bindParam(':code', $trimmed_code, PDO::PARAM_STR);
        //         $market_stmt2->execute();
                
        //         $market_price = $market_stmt2->fetch(PDO::FETCH_OBJ);
        //         error_log("Trimmed Wholesale Price result: " . json_encode($market_price));
        //     }
        //     exit(var_dump($market_price));
            
        //     // Add Wholesale Price to product object
        //     $product->market_price = $market_price ? $market_price->price : null;
            
        //     return [$product];
        // }
        public function fetch_product_with_market_price($barcode_or_name, $branch_id)
        {
            // Use a direct query with COALESCE to handle NULL Wholesale Prices
            $sql = "
                SELECT * FROM products 
                WHERE name = :barcode_or_name OR code = :barcode_or_name OR barcode = :barcode_or_name
                LIMIT 1
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':barcode_or_name', $barcode_or_name, PDO::PARAM_STR);
            $stmt->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $error = $stmt->errorInfo();
                error_log("ERROR: Direct query failed - " . json_encode($error));
                return [];
            }

            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            if (count($result) > 0) {
                error_log("DEBUG: Direct query result - " . json_encode($result[0]));
            } else {
                error_log("DEBUG: No results from direct query");
            }
            
            return $result;
        }

    public function select_market_row($bar_or_name, $branch_id) {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $market_sql = "
                SELECT price 
                FROM market_products 
                WHERE branch_id = :branch_id 
                AND (name = :name OR code = :code)
                LIMIT 1
            ";
            $market_stmt = $this->pdo->prepare($market_sql);
            $market_stmt->bindValue(':branch_id', (int)$branch_id, PDO::PARAM_INT);
            $market_stmt->bindValue(':name', $bar_or_name, PDO::PARAM_STR);
            $market_stmt->bindValue(':code', $bar_or_name, PDO::PARAM_STR);

            $executed = $market_stmt->execute();
            if (!$executed) {
                $err = $market_stmt->errorInfo();
                error_log("ERROR: select_market_row execute failed: " . json_encode($err));
                return null;
            }

            $market_price = $market_stmt->fetch(PDO::FETCH_OBJ); // object or false
            if (!$market_price) {
                error_log("DEBUG: select_market_row no market row for '{$bar_or_name}' branch {$branch_id}");
                return null;
            }

            error_log("DEBUG: select_market_row result: " . json_encode($market_price));
            return $market_price;
        } catch (\Throwable $e) {
            error_log("ERROR: select_market_row exception: " . $e->getMessage());
            return null;
        }
    }


        public function select_all_two_or_cond_branch($table, $first_column, $first_keyword, $second_column, $second_keyword) {
            $query = "SELECT * FROM `$table` WHERE ";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= "branch_id = :branch_id AND ";
            }
            
            $query .= "(`$first_column` = :first_keyword OR `$second_column` = :second_keyword)";
            
            $stmt = $this->pdo->prepare($query);
            
            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }
            
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            
            $stmt->execute();
            return $stmt->fetch();
        }

        public function select_one_row($table, $column, $value) {
            // Prepare the SQL statement
            $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE `$column` = ?");
            
            // Execute with the value
            $stmt->execute([$value]);
            
            // Fetch single row as object
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        // fetching with inner join with no condition
        public function fetch_innerjoin($first_table, $second_table, $initial_id, $order_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON `$initial_id` = b.id ORDER BY `$order_id` ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // fetching with inner join with no condition, limit desc
        public function fetch_innerjoin_limit_desc($first_table, $second_table, $initial_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON `$initial_id` = b.id ORDER BY a.id DESC LIMIT 250");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // fetching with inner join with no condition descending order
        public function fetch_innerjoin_desc($first_table, $second_table, $initial_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON `$initial_id` = b.id ORDER BY a.id DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // fetching with inner join of 1 conditions
        public function fetch_innerjoin_one_cond($first_table, $second_table, $initial_id, $column, $keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON `$initial_id` = b.id WHERE `$column` = :keyword ORDER BY a.id DESC");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // fetching of unanswered questions with inner join of 1 conditions
        public function fetch_questions_innerjoin_one_cond($first_table, $second_table, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.lecturer_id = b.id WHERE `$first_column` = :first_keyword AND `$second_column` = :second_keyword ORDER BY a.id DESC");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // fetching with inner join of 2 conditions using default id
        public function fetch_innerjoin_two_cond($first_table, $second_table, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.department = b.id WHERE `$first_column` = :first_keyword AND `$second_column` = :second_keyword ORDER BY a.id ASC");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }


        // fetching with inner join of 2 conditions and 2 deafult On conditions
        public function fetch_innerjoin_two_cond_two_on($first_table, $second_table, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.level = b.semester AND a.dept = b.department WHERE `$first_column` = :first_keyword AND `$second_column` = :second_keyword ORDER BY a.id ASC");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        
        // fetching with inner join of 3 conditions and 2 deafult On conditions
        public function fetch_innerjoin_three_cond_two_on($first_table, $second_table, $first_column, $first_keyword, $second_column, $second_keyword, $third_column, $third_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.level = b.semester AND a.dept = b.department WHERE `$first_column` = :first_keyword AND `$second_column` = :second_keyword AND `$third_column` = :third_keyword ORDER BY a.id ASC");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":third_keyword", $third_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // fetching with inner join of 3 conditions and 3 deafult On conditions
        public function fetch_innerjoin_three_cond_three_on($first_table, $second_table, $first_keyword, $second_keyword, $third_keyword) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.level = b.level AND a.dept = b.dept AND a.question_id = b.id WHERE a.level = :first_keyword AND a.dept = :second_keyword AND a.question_id = :third_keyword ORDER BY a.id ASC");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":third_keyword", $third_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // fetching between 2 dates
        public function fetch_btw_val($first_table, $second_table, $first_value, $second_value) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.user_id = b.id WHERE a.created_at >= :firstCol AND a.created_at <= :secondCol");
            $stmt->bindParam(":firstCol", $first_value, PDO::PARAM_STR);
            $stmt->bindParam(":secondCol", $second_value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // fetch innerjoin between value for search
        public function fetch_innerjoin_btw_values($first_table, $second_table, $initial_id, $first_value, $second_value, $third_table) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b INNER JOIN `$third_table` AS c ON `$initial_id` = b.id WHERE a.created_at >= :firstCol AND a.created_at <= :secondCol");
            $stmt->bindParam(":firstCol", $first_value, PDO::PARAM_STR);
            $stmt->bindParam(":secondCol", $second_value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // fetching with inner join with no condition descending order
        public function fetch_three_innerjoin_desc($first_table, $second_table, $third_table, $initial_id, $order_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b INNER JOIN `$third_table` AS c ON `$initial_id` = b.id ORDER BY `$order_id` DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // counting all from database in a table
        public function count_all_col($table, $column) {
            $query = "SELECT COUNT('".$column."') FROM `$table`";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " WHERE branch_id = :branch_id";
            }
            
            $stmt = $this->pdo->prepare($query);
            // var_dump($stmt);

            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }

            $stmt->execute();
            return $stmt->fetchcolumn();
        }

        // counting from database with 2 conditions
        public function count_two_cond($table, $column, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT COUNT('".$column."') FROM `$table` WHERE `$first_column` = :first_keyword AND `$second_column` = :second_keyword");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchcolumn();
        }


        //delete function
        public function delete($table, $column, $keyword) {
            $stmt = $this->pdo->prepare("DELETE FROM `$table` WHERE `$column` = :keyword");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            if($stmt->execute()) {
                return true;
            } else {
                //print error if something goes wrong
                printf("Error %s. \n", $stmt->error);
                return false;
            }
        }
        
        
        //sum of all columns
        public function sum_all_column($table, $column) {
            $query = "SELECT SUM($column) FROM `$table`";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " WHERE branch_id = :branch_id";
            }

            $stmt = $this->pdo->prepare($query);

            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }

            $stmt->execute();
            return $stmt->fetchcolumn();
        }


        //sum of all multiplied columns
        public function sum_all_multiplied_column($table, $first_column, $second_column) {
            $stmt = $this->pdo->prepare("SELECT SUM($first_column * $second_column) FROM `$table`");
            // SELECT SUM(price * quantity) AS total_value FROM `products`;
            $stmt->execute();
            return $stmt->fetchcolumn();
        }

        
        //sum of columns with one conditions
        public function sum_column_one_cond($table, $actual_column, $column, $keyword) {
            $stmt = $this->pdo->prepare("SELECT SUM($actual_column) FROM `$table` WHERE `$column` LIKE '$keyword'");
            // $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchcolumn();
        }
        
        //sum of columns with two conditions for search
        public function sum_search_column_one_cond($table, $actual_column, $column, $keyword) {
            $query = "SELECT SUM($actual_column) FROM `$table` WHERE DATE(`$column`) = :keyword";
        
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " AND branch_id = :branch_id";
            }
        
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':keyword', $keyword);
        
            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }
        
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        
        //sum of columns with two conditions for expense
        public function sum_search_column_one_cond_exp($table, $actual_column, $column, $keyword) {
            $query = "SELECT SUM($actual_column) FROM `$table` WHERE DATE(`$column`) = :keyword";
        
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " AND exp_branch_id = :branch_id";
            }
        
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':keyword', $keyword);
        
            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }
        
            $stmt->execute();
            return $stmt->fetchColumn();
        }


        // counting from database with 1 condition
        public function count_one_cond($table, $actual_column, $column, $keyword) {
            $query = "SELECT COUNT('".$actual_column."') FROM `$table` WHERE `$column` LIKE '%$keyword%'";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " AND branch_id = :branch_id";
            }

            $stmt = $this->pdo->prepare($query);

            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }

            $stmt->execute();
            return $stmt->fetchcolumn();
        }


        public function sum_between_two_cases($table, $actual_column, $first_column, $higherVar, $lowerVar) {
            $query = "SELECT SUM($actual_column) FROM `$table` WHERE `$first_column` BETWEEN '$higherVar' AND '$lowerVar'";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " AND branch_id = :branch_id";
            }

            $stmt = $this->pdo->prepare($query);

            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }

            $stmt->execute();
            return $stmt->fetchcolumn();
        }


        public function sum_between_two_cases_exp($table, $actual_column, $first_column, $higherVar, $lowerVar) {
            $query = "SELECT SUM($actual_column) FROM `$table` WHERE `$first_column` BETWEEN '$higherVar' AND '$lowerVar'";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " AND exp_branch_id = :branch_id";
            }

            $stmt = $this->pdo->prepare($query);

            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }

            $stmt->execute();
            return $stmt->fetchcolumn();
        }

        // counting from database with no condition
        public function count_between_cases($table, $count_column, $column, $higherVar, $lowerVar) {
            $query = "SELECT COUNT('".$count_column."') FROM `$table` WHERE `$column` BETWEEN '$higherVar' AND '$lowerVar'";
            
            // Add branch filter if a branch ID is set in the session
            if (isset($_SESSION['branch_id'])) {
                $query .= " AND branch_id = :branch_id";
            }

            $stmt = $this->pdo->prepare($query);

            if (isset($_SESSION['branch_id'])) {
                $stmt->bindValue(':branch_id', $_SESSION['branch_id']);
            }

            $stmt->execute();
            return $stmt->fetchcolumn();
        }


        //sum of a column using two conditions
        public function sum_two_cond($table, $column, $first_column, $first_keyword, $second_column, $second_keyword) {
            $stmt = $this->pdo->prepare("SELECT SUM('".$column."') FROM `$table` WHERE `$first_column` = :first_keyword AND `$second_column` LIKE '%$second_keyword%'");
            $stmt->bindParam(":first_keyword", $first_keyword, PDO::PARAM_STR);
            // $stmt->bindParam(":second_keyword", $second_keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchcolumn();
        }


        // counting from database with no condition
        public function count_ono_cond($table, $count_column, $column, $keyword) {
            $stmt = $this->pdo->prepare("SELECT COUNT('".$count_column."') FROM `$table` WHERE `$column` = :keyword");
            $stmt->bindParam(":keyword", $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchcolumn();
        }

        
        public function uploadImage($file, $folderName) {
            // Ensure folder name has a trailing slash
            $folderName = rtrim($folderName, '/') . '/';
        
            // Use __DIR__ to reference the project directory
            $uploadDir = __DIR__ . '/../../' . $folderName;
        
            // Ensure the directory exists or create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            $filename = basename($file['name']);
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $newName = mt_rand(1111, 9999) . mt_rand(1111, 9999) . ".png";
            $joinFile = $uploadDir . $newName; // Full path to save the file
            $array_allow = array('jpg', 'png', 'jpeg');
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
            // Validate file size
            if ($fileSize > 3485760) {
                return "The image is more than 3MB.";
            }
        
            // Validate file extension
            if (!in_array($file_ext, $array_allow)) {
                return "The file extension of this image is not allowed.";
            }
        
            // Move the file to the target directory
            if (move_uploaded_file($fileTmp, $joinFile)) {
                // Return the relative path to the saved image
                return $folderName . $newName;
            } else {
                return "Failed to upload the image.";
            }
        }
        

        public function cloudinaryUpload($file, $folderName) {
            $filename = basename($file['name']);
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $array_allow = array('jpg', 'png', 'jpeg');
            $file_ext = strtolower(pathinfo($filename)['extension']);

            if ($fileSize > 3485760) {
                return "The Image is more than 3MB";
            } elseif (!in_array($file_ext, $array_allow)) {
                return "The File extension of this Image is not allowed";
            } else {
                try {
                    $uploadResult = (new UploadApi())->upload($fileTmp);
                    return $uploadResult['secure_url'];
                } catch (\Exception $e) {
                    // Fallback to offline upload
                    return $this->uploadImage($file, $folderName);
                }
            }
        }
        // public function cloudinaryUpload($file, $folderName)
        // {
        //     $filename = basename($file['name']);
        //     $fileTmp = $file['tmp_name'];
        //     $fileSize = $file['size'];

        //     $allowedExtensions = ['jpg', 'jpeg', 'png'];
        //     $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        //     if ($fileSize > 3485760) {
        //         return "The Image is more than 3MB";
        //     }

        //     if (!in_array($fileExt, $allowedExtensions)) {
        //         return "The File extension of this Image is not allowed";
        //     }

        //     try {
        //         $cloudName = $this->cloudName; // Ensure this is set in your class
        //         $apiKey = $this->apiKey;
        //         $apiSecret = $this->apiSecret;

        //         $timestamp = time();

        //         // Generate signature
        //         $signatureString = "folder={$folderName}&timestamp={$timestamp}{$apiSecret}";
        //         $signature = sha1($signatureString);

        //         $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

        //         $postFields = [
        //             'file' => new CURLFile($fileTmp),
        //             'api_key' => $apiKey,
        //             'timestamp' => $timestamp,
        //             'folder' => $folderName,
        //             'signature' => $signature,
        //         ];

        //         $ch = curl_init();

        //         curl_setopt_array($ch, [
        //             CURLOPT_URL => $url,
        //             CURLOPT_POST => true,
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_POSTFIELDS => $postFields,
        //         ]);

        //         $response = curl_exec($ch);

        //         if (curl_errno($ch)) {
        //             throw new Exception(curl_error($ch));
        //         }

        //         curl_close($ch);

        //         $result = json_decode($response, true);

        //         if (isset($result['secure_url'])) {
        //             return $result['secure_url'];
        //         }

        //         throw new Exception($result['error']['message'] ?? 'Cloudinary upload failed');

        //     } catch (\Exception $e) {
        //         // Optional fallback
                
        //         throw new Exception($result['error']['message'] ?? 'Cloudinary upload failed');
        //         return $this->uploadImage($file, $folderName);
        //     }
        // }


        public function query($stmt) {
            $stmt = $this->pdo->prepare ($stmt);
            $stmt->execute();
            return $stmt;
        }


        public function userData($user_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `id` = :id");
            $stmt->bindParam(":id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function updateProductQuantity($code, $quantity) {
            $stmt = $this->pdo->prepare("UPDATE `market_products` SET quantity = :quantity WHERE code = :code");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            return $stmt->execute() ? true : false;
            // return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function create($table, $fields = array()) {
            $columns = implode(',', array_keys($fields));
            $values = ':'.implode(', :', array_keys($fields));
            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        
            // Prepare the SQL statement
            if($stmt = $this->pdo->prepare($sql)) {
        
                // Bind each value to the corresponding placeholder
                foreach($fields as $key => $data) {
                    $stmt->bindValue(':'.$key, $data); // Correcting the bindValue syntax
                }
        
                // Execute the statement and check for success
                $finalise = $stmt->execute();
        
                if($finalise) {
                    // If successful, return the last inserted ID
                    return $this->pdo->lastInsertId();
                } else {
                    // Output any error messages for debugging
                    printf("Error: %s. \n", $stmt->errorInfo()[2]); // Fetch the detailed error message
                    return false;
                }
            } else {
                // Handle the case where the statement preparation failed
                printf("Error preparing statement: %s. \n", $this->pdo->errorInfo()[2]);
                return false;
            }
        }

    
        // public function update($table, $id, $fields = array()) {
        //     $columns = '';
        //     $i = 1;

        //     foreach($fields as $name => $value) {
        //         if($i == 1)$columns .= "`$name` = '$value'";
        //         else $columns .= ", `$name` = '$value'";
        //         $i++;
        //     }

        //     $sql = "UPDATE $table SET $columns WHERE `id` = {$id}";
        //     $stmt = $this->pdo->prepare($sql);
        //     return $stmt -> execute();
        // }
        public function update($table, $id, $fields = array()) {
            $columns = '';
            $i = 1;

            foreach($fields as $name => $value) {
                if($i == 1) $columns .= "`$name` = '$value'";
                else $columns .= ", `$name` = '$value'";
                $i++;
            }

            $sql = "UPDATE $table SET $columns WHERE `id` = {$id}";
            
            try {
                $stmt = $this->pdo->prepare($sql);
                $result = $stmt->execute();
                
                if (!$result) {
                    // Log or display error
                    error_log("Update failed for table: $table, ID: $id, SQL: $sql");
                    error_log("PDO Error: " . print_r($stmt->errorInfo(), true));
                    return false;
                }
                
                return $result;
            } catch (Exception $e) {
                error_log("Update Exception: " . $e->getMessage());
                return false;
            }
        }
    

        public function loggedIn() {
            return (isset($_SESSION['id'])) ? true : false;
        }


        // Fetch menus for a specific user
        public function getMenuByUser($userId) {
            // Join `pages` and `user_pages` to get pages available to the user
            $stmt = $this->pdo->prepare("
                SELECT p.* 
                FROM `pages` p
                INNER JOIN `user_pages` up ON p.id = up.page_id
                WHERE up.user_id = :userId
                AND p.status = 'page'
                ORDER BY p.sub_menu ASC, p.id ASC
            ");
            $stmt->execute(['userId' => $userId]);
            $menuItems = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Organize the menu structure
            $menu = [];
            foreach ($menuItems as $item) {
                if (empty($item->sub_menu)) {
                    // Parent menu
                    $menu[$item->id] = [
                        'page_name' => $item->page_name,
                        'route' => $item->route,
                        'submenus' => []
                    ];
                } else {
                    // Submenu
                    $menu[$item->sub_menu]['submenus'][] = $item;
                }
            }

            return $menu;
        }

        // Render the menu as HTML
        public function renderMenu($menu) {
            $html = '';

            foreach ($menu as $menuItem) {
                $html .= '<div class="pcoded-navigation-label">' . htmlspecialchars($menuItem['page_name']) . '</div>';
                if (!empty($menuItem['submenus'])) {
                    $html .= '<ul class="pcoded-item pcoded-left-item">';
                    foreach ($menuItem['submenus'] as $submenu) {
                        $html .= '
                            <li>
                                <a href="' . htmlspecialchars($submenu->route) . '" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>FC</b></span>
                                    <span class="pcoded-mtext">' . htmlspecialchars($submenu->page_name) . '</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        ';
                    }
                    $html .= '</ul>';
                }
            }

            return $html;
        }

                
        // select all fromk a table with a condition
        public function select_all_greater_value($table, $column) {
            $stmt = $this->pdo->prepare("SELECT `$column` FROM `$table` WHERE `$column` >= 1");
            // $stmt->bindValue(":keyword", $keyword, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }


        // Fetch user's assigned pages
        private function fetchUserPages($userId) {
            $stmt = $this->pdo->prepare("SELECT page_id FROM user_pages WHERE user_id = :userId");
            $stmt->execute(['userId' => $userId]);
            return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'page_id');
        }
        
        public function groupPages() {
            $stmt = $this->pdo->prepare("SELECT * FROM pages ORDER BY id ASC");
            $stmt->execute();
            $pages = $stmt->fetchAll(PDO::FETCH_OBJ);
        
            $groupedPages = ['main' => [], 'sub' => []];
        
            foreach ($pages as $page) {
                if (empty($page->sub_menu)) {
                    $groupedPages['main'][$page->id] = $page;
                } else {
                    $groupedPages['sub'][$page->sub_menu][] = $page;
                }
            }
        
            return $groupedPages;
        }

        function renderNestedPageEditForm($userId) {
            $groupedPages = $this->groupPages();
            $userPages = $this->fetchUserPages($userId);

            echo '<style>
                .page-access-container { padding: 20px; }
                .main-page-section { margin-bottom: 25px; border: 1px solid #e9ecef; border-radius: 12px; overflow: hidden; }
                .main-page-header { background: #f8f9fa; padding: 15px 20px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; }
                .main-page-title { font-weight: 600; color: #212529; margin: 0; user-select: none; }
                .sub-pages-container { padding: 20px; background: white; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px; }
                .sub-page-item { display: flex; align-items: center; padding: 12px 15px; background: #f8f9fa; border-radius: 8px; }
                .sub-page-checkbox { margin-right: 12px; transform: scale(1.2); }
                .sub-page-label { flex: 1; cursor: pointer; user-select: none; }
                .access-badge { background: #e7f1ff; color: #0d6efd; padding: 3px 8px; border-radius: 4px; font-size: 12px; margin-left: 10px; }
                .checkbox-indicator { width: 20px; height: 20px; border: 2px solid #dee2e6; border-radius: 4px; position: relative; cursor: pointer; }
                .checkbox-indicator.checked { background: #0d6efd; border-color: #0d6efd; }
                .checkbox-indicator.checked:after { content: "✓"; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; }
                .checkbox-indicator.indeterminate { background: #0d6efd; border-color: #0d6efd; }
                .checkbox-indicator.indeterminate:after { content: "—"; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; }
                .form-actions { margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; text-align: center; }
            </style>';

            echo '<form method="POST" action="validation/update_user_pages" id="pageAccessForm">';
            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($userId) . '">';

            foreach ($groupedPages['main'] as $mainId => $mainPage) {
                $subPages = isset($groupedPages['sub'][$mainId]) ? $groupedPages['sub'][$mainId] : [];
                $subPageIds = array_column($subPages, 'id');
                $selectedSubPages = array_intersect($subPageIds, $userPages);
                $allSelected = !empty($subPages) && count($selectedSubPages) == count($subPages);
                $someSelected = !empty($subPages) && count($selectedSubPages) > 0 && count($selectedSubPages) < count($subPages);

                echo '<div class="main-page-section" data-main-id="' . $mainId . '">';
                echo '<div class="main-page-header" onclick="toggleAllSubPages(' . $mainId . ')">';
                echo '<div class="main-page-title">' . htmlspecialchars($mainPage->page_name) . 
                    '<span class="access-badge">' . count($selectedSubPages) . '/' . count($subPages) . ' selected</span></div>';
                echo '<div class="checkbox-indicator ' . ($allSelected ? 'checked' : ($someSelected ? 'indeterminate' : '')) . '" 
                    onclick="event.stopPropagation(); toggleAllSubPages(' . $mainId . ')"></div>';
                echo '</div>';

                if (!empty($subPages)) {
                    echo '<div class="sub-pages-container">';
                    foreach ($subPages as $subPage) {
                        $isSubChecked = in_array($subPage->id, $userPages);
                        echo '<div class="sub-page-item">';
                        echo '<input type="checkbox" name="pages[]" value="' . $subPage->id . '" 
                            id="sub_' . $mainId . '_' . $subPage->id . '" 
                            class="sub-page-checkbox sub-page-' . $mainId . '"
                            data-main-id="' . $mainId . '" ' . ($isSubChecked ? 'checked' : '') . '>';
                        echo '<label for="sub_' . $mainId . '_' . $subPage->id . '" class="sub-page-label">' . 
                            htmlspecialchars($subPage->page_name) . '</label>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            }

            echo '<div class="form-actions">';
            echo '<button type="submit" class="btn btn-primary">Update Pages</button>';
            echo '</div>';

            echo '<script>
                function toggleAllSubPages(mainId) {
                    const checkboxes = document.querySelectorAll(".sub-page-" + mainId);
                    const checkedBoxes = document.querySelectorAll(".sub-page-" + mainId + ":checked");
                    const allChecked = checkedBoxes.length === checkboxes.length;
                    
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });
                    
                    updateMainCheckbox(mainId);
                }
                
                function updateMainCheckbox(mainId) {
                    const checkboxes = document.querySelectorAll(".sub-page-" + mainId);
                    const checkedBoxes = document.querySelectorAll(".sub-page-" + mainId + ":checked");
                    const indicator = document.querySelector(".main-page-section[data-main-id=\"" + mainId + "\"] .checkbox-indicator");
                    const badge = document.querySelector(".main-page-section[data-main-id=\"" + mainId + "\"] .access-badge");
                    
                    if (checkedBoxes.length === 0) {
                        indicator.className = "checkbox-indicator";
                    } else if (checkedBoxes.length === checkboxes.length) {
                        indicator.className = "checkbox-indicator checked";
                    } else {
                        indicator.className = "checkbox-indicator indeterminate";
                    }
                    
                    if (badge) {
                        badge.textContent = checkedBoxes.length + "/" + checkboxes.length + " selected";
                    }
                }
                
                document.querySelectorAll(".sub-page-checkbox").forEach(checkbox => {
                    checkbox.addEventListener("change", function() {
                        updateMainCheckbox(this.dataset.mainId);
                    });
                });
                
                document.querySelectorAll(".main-page-section").forEach(section => {
                    updateMainCheckbox(section.dataset.mainId);
                });
            </script>';

            echo '</form>';
        }
        
        // public function createklhd($table, $fields = array()) {
        //     // remove the , from the key values in the fields(i.e the values input into databse)
        //     $columns = implode(',', array_keys($fields));
        //     $values = ':'.implode(', :', array_keys($fields));
        //     $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        //     if($stmt = $this->pdo->prepare($sql)) {
        //         foreach($fields as $key => $data) {
        //             $stmt->bindValue(`:`.$key, $data);
        //         }
        //         $stmt->execute();
        //         return $this->pdo->lastInsertId();
        //     }
        // }
    }
