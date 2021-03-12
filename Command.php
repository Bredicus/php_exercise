<?php
abstract class Command
{
    abstract protected function getResult($values);

    public function printResult($values) {
        print($this->getResult($values) . "\n");
    }

    protected function isNumeric($array) {
        return ctype_digit(implode('',$array));
    }
}

class Add extends Command
{
    protected function getResult($values) {
        if (ctype_digit(implode('', $values))) {
            return array_sum($values);
        }
        else {
            return "Invalid arguments for add command";
        }
    }
}

class SortAsc extends Command
{
    protected function getResult($values) {
        sort($values);
        return implode(', ', $values);
    }
}

class RepoDesc extends Command
{
    protected function getResult($values) {
        if (count($values) === 2) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://api.github.com/repos/" . $values[0] . "/" . $values[1]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_USERAGENT, "WHC Github API Task");
            $response = curl_exec($curl);
            curl_close($curl);

            $data = json_decode($response);

            return isset($data->description) ? $data->description : "Repository not found";
        }
        else {
            return "Invalid arguments count for repo-desc command, enter owner and repository names only";
        }
    }
}
?>