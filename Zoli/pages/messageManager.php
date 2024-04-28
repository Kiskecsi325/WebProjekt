<?php
class MessageManager
{


    function __construct()
    {

    }
    
    function save_message(string $path, array $data) {
        $users = $this->load_message($path);
    
        $users["messages"][] = $data;
    
        $json_data = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
        file_put_contents($path, $json_data);
      }


    function load_message(string $path): array
    {
        if (!file_exists($path))
            die("Nem sikerült a fájl megnyitása!");

        $json = file_get_contents($path);

        return json_decode($json, true);
    }

    



    function sendMessage($sender, $receiver, $message) {
        // Betöltjük az eddigi üzeneteket
    
        // Hozzáadjuk az új üzenetet
        $newMessage = [
            "id" => uniqid(),// Egyedi azonosító generálása
            "sender" => $sender,
            "receiver" => $receiver,
            "message" => $message
        ];
    
        // Menti az új üzeneteket a JSON fájlba
       $this->save_message("message.json", $newMessage);
       header("Location: message.php");
       return true;
    }
    

    
    function getMessages($receiver) {
        $messagesData = @file_get_contents("message.json");
    
        if ($messagesData === false) {
            // Ha a fájl nem létezik vagy nem sikerült beolvasni, hibaüzenetet adunk vissza
            return array("error" => "Nem sikerült betölteni az üzeneteket.");
        }
    
        // JSON adatok dekódolása
        $messagesData = json_decode($messagesData, true);
    
        if ($messagesData === null) {
            // Ha a fájl tartalma érvénytelen JSON, hibaüzenetet adunk vissza
            return array("error" => "Érvénytelen üzeneteket tartalmazó fájl.");
        }
    
        // Ha minden rendben van, feldolgozzuk az üzeneteket
        $receiverMessages = array_filter($messagesData["messages"], function($message) use ($receiver) {
            return $message["receiver"] == $receiver;
        });
    
        return $receiverMessages;
    }
    
    function delete_message($id)
{
    $messages = $this->load_message("message.json");
    $newMessages = [];
    foreach ($messages["messages"] as $message) {
        if ($message["id"] != $id) {
            $newMessages[] = $message;
        }
    }
    $messages["messages"] = $newMessages;
    $json_data = json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents("message.json", $json_data);
}

    function load_users(string $path): array
    {
        if (!file_exists($path))
            die("Nem sikerült a fájl megnyitása!");

        $json = file_get_contents($path);

        return json_decode($json, true);
    }


}

?>