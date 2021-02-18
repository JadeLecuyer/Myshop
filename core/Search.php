<?php
require_once 'DBconfig.php';
require_once 'core/Database.php';

class Search extends Database {
    
    /**
     * buildQuery
     * sanitize and verify search input
     * build sql query with names placeholders
     * build parameters array
     *
     * @param  string $searchCriteria
     * @param  string $categoryId
     * @param  string $max_price
     * @param  string $min_price
     * @param  string $sorting
     * @return array success status with build sql query and parameters array or fail status with error messages
     */
    public function buildQuery($searchCriteria, $categoryId, $max_price, $min_price, $sorting) {
        if(!empty($max_price)) {
            $max_price = filter_var($max_price, FILTER_SANITIZE_NUMBER_INT);
            if ($max_price === false) {
                $errorMessage[] = 'Le prix maximum n\'est pas valable.';
            } else {
                $max_price = intval($max_price);
                if ($max_price <= 0) {
                    $errorMessage[] = 'Le prix maximum ne peut pas être inférieur ou égal à 0.';
                }
            }
        }

        if(!empty($min_price)) {
            $min_price = filter_var($min_price, FILTER_SANITIZE_NUMBER_INT);
            if ($min_price === false) {
                $errorMessage[] = 'Le prix minimum n\'est pas valable.';
            } else {
                $min_price = intval($min_price);
                if ($min_price < 0) {
                    $errorMessage[] = 'Le prix maximum ne peut pas être négatif.';
                }  elseif (!empty($max_price) && $max_price < $min_price) {
                    $errorMessage[] = 'Le prix minimum ne peut pas être supérieur au prix maximum.';
                }
            }
        }

        if(!empty($categoryId)) {
            $categoryId = filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);
            if ($categoryId === false) {
                $errorMessage[] = 'La catégorie n\'est pas valable.';
            } elseif (!$this->getCategory($categoryId)) {
                $errorMessage[] = 'La catégorie n\'existe pas.';
            }
        }

        if(!empty($searchCriteria)) {
            $searchCriteria = filter_var($searchCriteria, FILTER_SANITIZE_STRING);
            if ($searchCriteria === false) {
                $errorMessage[] = 'Les critères de recherche ne sont pas valables.';
            }
            $searchCriterias = explode(' ', $searchCriteria);
            foreach($searchCriterias as $key => $searchCriteria) {
                $searchCriterias[$key] = '%' . $searchCriteria . '%';
            }
        }

        if (count($errorMessage) === 0) {
            $request = 'SELECT * FROM products';
            $parameters = [];
            $criteriaNumber = 0;

            if (!empty($categoryId)) {
                if (empty($this->getCategoryChildren($categoryId))) {
                    if($criteriaNumber === 0) {
                        $request .= ' WHERE category_id = :categoryId';
                    } else {
                        $request .= ' AND category_id = :categoryId';
                    }
                    $parameters['categoryId'] = $categoryId;
                    $criteriaNumber ++;
                } else {
                    $childrenCategoriesIds = $this->getAllChildrenIds($categoryId);
                    //put the parent id in the array to also get the products that are only in this category and not in children categories
                    $childrenCategoriesIds[] = $categoryId;
                    $i = 0;
                    $in = "";
                    foreach ($childrenCategoriesIds as $childId)
                    {
                        $key = ":id".$i++;
                        $in .= "$key,"; //build the string of named placeholders to put in the 'in' sql clause
                        $childrenIds[$key] = $childId; //build the parameters array with the researched ids
                    }
                    $in = rtrim($in,","); //take out the final ','
                    if($criteriaNumber === 0) {
                        $request .= " WHERE category_id IN ($in)";
                    } else {
                        $request .= " AND category_id IN ($in)";
                    }
                    $parameters = array_merge($parameters, $childrenIds);
                    $criteriaNumber ++;
                }
            }

            if (!empty($min_price)) {
                if($criteriaNumber === 0) {
                    $request .= ' WHERE price >= :min_price';
                } else {
                    $request .= ' AND price >= :min_price';
                }
                $parameters['min_price'] = $min_price;
                $criteriaNumber ++;
            }

            if (!empty($max_price)) {
                if($criteriaNumber === 0) {
                    $request .= ' WHERE price <= :max_price';
                } else {
                    $request .= ' AND price <= :max_price';
                }
                $parameters['max_price'] = $max_price;
                $criteriaNumber ++;
            }

            if (!empty($searchCriterias)) {
                $i = 0;
                foreach ($searchCriterias as $searchCriteria) {
                    if($criteriaNumber === 0) {
                        $request .= ' WHERE name LIKE :searchCriteria' . $i;
                    } else {
                        $request .= ' AND name LIKE :searchCriteria' . $i;
                    }
                    $parameters['searchCriteria' . $i] = $searchCriteria;
                    $criteriaNumber ++;
                    $i++;
                }
            }

            if (!empty($sorting)) {
                switch($sorting) {
                    case 'price_asc' :
                        $request .= ' ORDER BY price';
                        break;
                    case 'price_desc' :
                        $request .= ' ORDER BY price DESC';
                        break;
                    case 'alphabet_asc' :
                        $request .= ' ORDER BY name';
                        break;
                    case 'alphabet_desc' :
                        $request .= ' ORDER BY name DESC';
                        break;
                }
            }

            return ['status' => 'success', 'query' => $request, 'parameters' => $parameters];

        } else {
            return ['status' => 'fail', 'message' => $errorMessage];
        }
    }
    
    /**
     * searchMatches
     *
     * @param  string $searchCriteria
     * @param  string $categoryId
     * @param  string $max_price
     * @param  string $min_price
     * @param  string $sorting
     * @return array fail status with error messages array or success status with matched results array
     */
    public function searchMatches($searchCriteria, $categoryId, $max_price, $min_price, $sorting) {
        // verify and sanitize input, build the prepared query and the parameters array
        $query = $this->buildQuery($searchCriteria, $categoryId, $max_price, $min_price, $sorting); 

        if ($query['status'] === 'success') {
            try {
                $req = $this->dbConnection->prepare($query['query']);
                $req->execute($query['parameters']);
                $results = $req->fetchAll(PDO::FETCH_ASSOC);
            }
            catch (Exception $e) {
                error_log($e->getMessage() . "\n", 3, $this->errorLogFile);
                echo 'ERROR: more info in ' . $this->errorLogFile . "\n";
            }

            return ['status' => 'success', 'results' => $results];
        } else {
            return ['status' => 'fail', 'message' => $query['message']];
        }
    }
}