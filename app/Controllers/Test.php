<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function database()
    {
        echo "<h2>Database Connection Test</h2>";
        
        try {
            $db = \Config\Database::connect();
            echo "<p style='color: green'>✓ Successfully connected to the database!</p>";
            
            // List all tables
            $query = $db->query("SHOW TABLES");
            echo "<h3>Tables in your database:</h3>";
            
            if ($query->getNumRows() > 0) {
                echo "<ul>";
                foreach ($query->getResult() as $row) {
                    $table = array_values(get_object_vars($row))[0];
                    echo "<li><strong>$table</strong>";
                    
                    // Also check table structure
                    $structure = $db->query("DESCRIBE $table");
                    echo "<ul>";
                    foreach ($structure->getResult() as $field) {
                        echo "<li>{$field->Field} - {$field->Type}</li>";
                    }
                    echo "</ul>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color: orange'>No tables found in the database. Make sure you've created the required tables.</p>";
            }
            
            // Check each required table
            $requiredTables = ['users', 'movies', 'watchlists', 'reviews'];
            echo "<h3>Required Tables Check:</h3>";
            echo "<ul>";
            
            foreach ($requiredTables as $table) {
                $tableExists = $db->query("SHOW TABLES LIKE '$table'");
                if ($tableExists->getNumRows() > 0) {
                    echo "<li style='color: green'>✓ Table '$table' exists</li>";
                    
                    // Count records
                    $countQuery = $db->query("SELECT COUNT(*) as total FROM $table");
                    $count = $countQuery->getRow()->total;
                    echo " ($count records)";
                } else {
                    echo "<li style='color: red'>✗ Table '$table' does not exist!</li>";
                }
            }
            echo "</ul>";
            
        } catch (\Exception $e) {
            echo "<p style='color: red'>Database connection failed: " . $e->getMessage() . "</p>";
            echo "<p>Please check your .env file and make sure:</p>";
            echo "<ul>";
            echo "<li>The database name 'movie_website' exists</li>";
            echo "<li>Your username and password are correct</li>";
            echo "<li>The MySQL service is running in XAMPP</li>";
            echo "</ul>";
        }
    }
}