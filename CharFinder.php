<!DOCTYPE html>
<html>
<br><br>
<form name="form" method="get">
    <label for="beyondid">D&D Beyond ID:</label><br>
    <input type="number" id="beyondid" name="beyondid"><br>
    <input type="submit" value="Submit">
</form>

    <?php

        $getForm = $_GET['beyondid'];

        $data = file_get_contents('https://character-service.dndbeyond.com/character/v3/character/' . $getForm . '/');

        echo "<br><br>";

        if($data == NULL){
            echo "No Character found.  Insert and submit an ID above.";
        }
        else{

            $decodedData = json_decode($data, true);
            echo "------------------- Character JSON Connection ------------------------ <br>";
            echo " D&D Beyond ID: " . $decodedData['data']['id'] . "<br>";
            echo "Success: " . $decodedData['success'] . "<br>";
            echo "Message: " . $decodedData['message'] . "<br>";
            echo "------------------- Character Info ------------------------ <br>";
            echo "Name:  " . $decodedData['data']['name'] . '<br>';
            echo "Gender:  " . $decodedData['data']['gender'] . '<br>';
            echo "Current XP:  " . $decodedData['data']['currentXp'] . '<br>';
            echo "------------------- Race Info ------------------------ <br>";
            echo "isHomebrew:  " . $decodedData['data']['race']['isHomebrew'] . '<br>';
            echo "hasSubRace:  " . $decodedData['data']['race']['isSubRace'] . '<br>';
            echo "Base Race Name:  " . $decodedData['data']['race']['baseRaceName'] . '<br>';
            echo "Sub Race Name:  " . $decodedData['data']['race']['subRaceShortName'] . '<br>';
            echo "Full Race Name:  " . $decodedData['data']['race']['fullName'] . '<br>';
            echo "------------------- Class Info ------------------------ <br>";
            echo "isHomebrew:  " . $decodedData['data']['classes'][0]['definition']['isHomebrew'] . '<br>' ;
            echo "isStartingClass:  " . $decodedData['data']['classes'][0]['isStartingClass'] . '<br>' ;
            echo "Class:  " . $decodedData['data']['classes'][0]['definition']['name'] . '<br>';
            echo "Subclass:  " . $decodedData['data']['classes'][0]['subclassDefinition']['name'] . '<br>';
            echo "Class Level:  " . $decodedData['data']['classes'][0]['level'] . '<br>';;
            echo "isMulticlassed:  " . '<br>';
            echo "------------------- Base Stats (without any bonuses) ------------------------ <br>";
            echo "Strength:  " . $decodedData['data']['stats'][0]['value'] . '<br>';
            echo "Dexterity:  " . $decodedData['data']['stats'][1]['value'] . '<br>';
            echo "Constitution:  " . $decodedData['data']['stats'][2]['value'] . '<br>';
            echo "Intelligence:  " . $decodedData['data']['stats'][3]['value'] . '<br>';
            echo "Wisdom:  " . $decodedData['data']['stats'][4]['value'] . '<br>';
            echo "Charisma:  " . $decodedData['data']['stats'][5]['value'] . '<br>';
            echo "--------------- Racial Bonuses -------------------- <br>";
            echo "Racial Description =>  " . $decodedData['data']['race']['description'] .  '<br>';
           
            echo "---------------------- Inventory ------------------------ <br>";
            $i = 0;
            foreach($decodedData['data']['inventory'] as $key => $value)
            {
                $quantity = $value['quantity'];
                $weight = $value['definition']['weight'];
                $bundleSize = $value['definition']['bundleSize']; 

                $bundleMath = (int) $quantity / (int) $bundleSize;
                $multiply = (int) $bundleMath * (int) $weight;

                echo $key . ' | Item: ' . $value['definition']['name'] . "<br>";
                echo "Quantity: " . $quantity . "<br>";
                echo "Weight: " . $weight . "<br>";
                echo "Bundle Size: " . $bundleSize . "<br>";
                echo "Total: " . $multiply . "<br><br>";

                $i++;
            }
        }
    ?>      
</html>
