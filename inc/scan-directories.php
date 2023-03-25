<?php

//  Example

//      [0] => Array
//         (
//             [filename] => _hm_status
//             [filepath] => D:\xamp\htdocs\vuldev\dev/_hm_status
//             [url] => https://jbc.test/vuldev/_hm_status
//             [name] => _HM_STATUS
//             [info] => Array
//                 (
//                     [message] => Why hello there! Don't forget to setup how the project json is going to be.
//                 )
//         )

class ScanDirectories
{
    private $url = '';
    private $projects = array();

    public function __construct($path, $dev_folder = 'dev')
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $hostname = $_SERVER['SERVER_NAME'];
        $uri = $_SERVER['REQUEST_URI'];
        $this->url = $protocol . "://" . $hostname . $uri . $dev_folder . '/';
        $this->find_projects($path . '\\' . $dev_folder);
    }
    public function get_projects()
    {
        return $this->projects;
    }

    private function find_projects($path)
    {
        if (file_exists($path)) {
            $files = scandir($path);
            $projects_to_show = array();
            $show = false;
            if ($files) {
                // echo '<pre><h1>FILES</h1>' . print_r($files, true) . '</pre>';

                foreach ($files as $file) {

                    if ($file === "." || $file === ".." || $file === "index.php") continue;
                    $show = false;
                    $project_placeholder = array();

                    //Don't show projects which start with '.'
                    if (strncmp(substr($file, 0, 1), '.', 1) === 0) continue;

                    if (is_dir($path . '/' . $file)) {

                        $full_path = $path . '/' . $file;
                        $localpath = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $full_path) . "\project.json";

                        //Don't show hidden directory projects which are projects that has a .project.json
                        //for those of us who still like seeing the directories in alphanumeric order as much as possible
                        if (file_exists($full_path . '/.project.json')) continue;

                        $name = ucwords(str_replace(array('-', '_'), array(' ', ' '), $file));
                        $project_placeholder = array(
                            'filename' => $file,
                            'filepath' => $full_path,
                            'localpath' => $localpath,
                            'dirpath' => $path,
                            'url' => $this->url . $file,
                            'name' => $name,
                            'is_dir' => true,
                            'info' => array()
                        );

                        if (file_exists($full_path . '/index.php') || file_exists($full_path . '/' . $file . '.php')) {
                            $show = true;

                            if (file_exists($full_path . '/project.json')) {
                                $project_json = file_get_contents(($full_path . '/project.json'));
                                $project_placeholder['info'] = json_decode($project_json, true);
                            } else {
                                $json = '{"overview": "Overview needs to be written","version": "1.0.0","scope": "Scope needs to be defined","category": "tool"}';
                                file_put_contents($full_path . '/project.json', $json);
                            }
                        }

                        if (file_exists($full_path . '/' . $file . '.php')) {
                            $project_placeholder['url'] = $project_placeholder['url'] . '/' . $file . '.php';
                        }
                    } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                        $show = true;
                        $full_path = $path . '/' . $file;
                        $localpath = str_replace('/', DIRECTORY_SEPARATOR, $full_path);

                        if (strncmp(substr($file, 0, 1), '.', 1) === 0) continue;

                        $name = ucwords(str_replace(array('.php', '-', '_'), array('', ' ', ' '), $file));
                        $project_placeholder = array(
                            'filename' => $file,
                            'filepath' => $full_path,
                            'localpath' => $localpath,
                            'dirpath' => $path,
                            'url' => $this->url . $file,
                            'name' => $name,
                            'is_dir' => false
                        );
                    }

                    if ($show) {
                        $projects_to_show[] = $project_placeholder;
                    }
                }
            }

            // echo '<pre><h1>PROJECTS</h1>' . print_r($projects_to_show, true) . '</pre>';
            $this->projects = $projects_to_show;
        }
    }
}
