<?php

class UserManager
{

    function __construct()
    {

    }

    function save_users(string $path, array $data)
    {
        $users = load_users($path);

        $users["users"][] = $data;

        $json_data = json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents($path, $json_data);
    }

    function load_users(string $path): array
    {
        if (!file_exists($path))
            die("Nem sikerült a fájl megnyitása!");

        $json = file_get_contents($path);

        return json_decode($json, true);
    }

    function login(string $username, string $password)
    {
        $fiokok = load_users("users.json"); // betöltjük a regisztrált felhasználók adatait, és eltároljuk őket a $fiokok változóban
        foreach ($fiokok["users"] as $fiok) {              // végigmegyünk a regisztrált felhasználókon
            // a bejelentkezés pontosan akkor sikeres, ha az űrlapon megadott felhasználónév-jelszó páros megegyezik egy regisztrált felhasználó belépési adataival
            // a jelszavakat hash alapján, a password_verify() függvénnyel hasonlítjuk össze
            if ($fiok["username"] === $username && password_verify($password, $fiok["password"])) {
                $uzenet = "Sikeres belépés!";
                $_SESSION["user"] = $fiok;              // a "user" nevű munkamenet-változó a bejelentkezett felhasználót reprezentáló tömböt fogja tárolni
                return true;                // ekkor átírjuk a megjelenítendő üzenet szövegét
                // mivel találtunk illeszkedést, ezért a többi felhasználót nem kell megvizsgálnunk, kilépünk a ciklusból 
            }
        }
        return false;
    }

    function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    function singup(string $username, string $password, string $password2, $age, $gender, $role, $hobbies): array
    {
        $fiokok = load_users("users.json");
        $hibak = [];
        foreach ($fiokok["users"] as $fiok) {
            if ($fiok["felhasznalonev"] === $username) {

                $hibak[] = "A felhasználónév már foglalt!";
                break;
            }
        }

        if (strlen($password) < 5)
            $hibak[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";

        if ($password !== $password2)
            $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";

        if ($age < 18)
            $hibak[] = "Csak 18 éves kortól lehet regisztrálni!";

        if (count($hibak) === 0) {   // sikeres regisztráció
            $jelszo = password_hash($password, PASSWORD_DEFAULT);       // jelszó hashelése
            // hozzáfűzzük az újonnan regisztrált felhasználó adatait a rendszer által ismert felhasználókat tároló tömbhöz
            $fiok = [
                "username" => $username,
                "password" => $jelszo,
                "age" => $age,
                "gender" => $gender,
                "role" => "user",
                "hobbies" => $hobbies,
            ];
            // elmentjük a kibővített $fiokok tömböt a users.json fájlba
            save_users("users.json", $fiok);
            header("Location: login.php");

        }
        return $hibak;
    }

    function delete_users(string $username)
    {
        $users = $this->load_users("users.json");
        $newusers = [];
        foreach ($users["users"] as $fiok) {              // végigmegyünk a regisztrált felhasználókon
            if ($fiok["username"] != $username) {
                $newusers[] = $fiok;
            }
        }
        $users["users"] = $newusers;
        $json_data = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents("users.json", $json_data);
    }

    function current_user()
    {
        return $_SESSION["user"];
    }

    function update_user_basicdata(string $username, $age, $gender, $role, $hobbies): array
    {
        $user_data = $this->find_user_by_username($username);
        $hibak=[];
        if ($user_data) {

            if ($age < 18)
                $hibak[] = "Csak 18 éves kortól lehet regisztrálni!";

            if (count($hibak) === 0) {   // sikeres regisztráció
                $this->delete_users($username);
                $fiok = [
                    "username" => $username,
                    "password" => $user_data["password"],
                    "age" => $age,
                    "gender" => $gender,
                    "role" => "user",
                    "hobbies" => $hobbies,
                ];
                // elmentjük a kibővített $fiokok tömböt a users.json fájlba
                save_users("users.json", $fiok);
            }
            return $hibak;
        }
        return array("nincs ilyen user");
    }

    function update_user_password(string $username, $password, string $password2): array
    {
        $user_data = $this->find_user_by_username($username);
        $hibak=[];
        if ($user_data) {
            if (strlen($password) < 5)
                $hibak[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";

            if ($password !== $password2)
                $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";


            // sikeres regisztráció
            $jelszo = password_hash($password, PASSWORD_DEFAULT);

            if (count($hibak) === 0) {   // sikeres regisztráció
                $this->delete_users($username);
                $fiok = [
                    "username" => $username,
                    "password" => $jelszo,
                    "age" => $user_data["age"],
                    "gender" => $user_data["gender"],
                    "role" =>  $user_data["role"],
                    "hobbies" => $user_data["hobbies"],
                ];
                // elmentjük a kibővített $fiokok tömböt a users.json fájlba
                save_users("users.json", $fiok);
            }
            return $hibak;
        }
        return array("nincs ilyen user");
    }


    function find_user_by_username(string $username)
    {
        $users = $this->load_users("users.json");
        foreach ($users["users"] as $fiok) {              // végigmegyünk a regisztrált felhasználókon
            if ($fiok["username"] === $username) {
                return $fiok;
            }
        }
        return null;
    }
}
