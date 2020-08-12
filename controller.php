<?php
    class app {
        public $getRouters = [];
        private $postRouters = [];
        
        private $base = "";

        public function __construct(String $basePath = "") {
            $this->base = $basePath;
        }

        public function post($router, $handler){
            $this->postRouters[$router] = $handler;
        }
        
        public function get($router, $handler){
            $this->getRouters[$router] = $handler;
        }

        public function ready(){            

            $request = str_replace($this->base, "", $_SERVER["REQUEST_URI"]);
            if($request != "/"){
                $request = explode("/", $request);
                $request = array_filter($request); //Delete empty spaces
                $request = array_values($request); //Reset index number 
            }else{
                $request = ["/"];
            }
            
            if($_SERVER["REQUEST_METHOD"] == "GET"){
                $this->getRouters = $this->order_routers($this->getRouters);
                $this->handle_request($request, $this->getRouters);
            }else if ($_SERVER["REQUEST_METHOD"] == "POST"){
                $this->postRouters = $this->order_routers($this->postRouters);
                $this->handle_request($request, $this->postRouters);
            }
        }

        private function handle_request($request, $routers){
            $request_len = count($request);

            foreach($routers as $router => $handler){
                if($router != "/"){
                    $router = explode("/", $router);
                    $router = array_filter($router);
                    $router = array_values($router);
                }else{
                    $router = ["/"];
                }
                
                
                if(isset($request[0]) && $request[0] == $router[0] && $request_len >= count($router)){
                    $args = $this->load_http_get_elements($router, $request);
                    $handler(...$args);
                    break;
                }
            }
        }
        
        private function load_http_get_elements($router, $request){
            $args = [];

            foreach($router as $key => $value){
                if($value[0] == "{" && $value[-1] == "}"){
                    $len = strlen($value);
                    $name = substr($value, 1, ($len-2));
                    
                    $_GET[$name] = $request[$key];
                    $args[$name] = $request[$key];
                }
            }

            return array_values($args);
        }

        private function order_routers($routers){
            function filter($a,$b){ return strlen($b)-strlen($a); }
            uksort($routers,'filter'); 
            return $routers;
        }
    }
?>