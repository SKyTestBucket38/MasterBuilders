<?php

namespace XxCreditIsGoodXx\MasterBuilders;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\CallbackTask;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    public $bb = array();
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->bb = array();
        $this->bb[0] = 0; // is the game running       
        $this->bb[1] = 0; // what you need to build
        
        $this->bb[2] = 0; // overall rating of 1 built
        $this->bb[3] = 0; // overall rating of 2 built
        $this->bb[4] = 0; // overall rating of 3 built
        $this->bb[5] = 0; // overall rating of 4 built
        $this->bb[6] = 0; // overall rating of 5 built
        $this->bb[7] = 0; // overall rating of 6 built
        $this->bb[8] = 0; // overall rating of 7 built
        $this->bb[9] = 0; // overall rating of 8 built
        $this->bb[10] = 0; // overall rating of 9 build
        $this->bb[11] = 0; // overall rating of 10 built
        
        $this->bb[12] = 0; // nickname builder 1 built
        $this->bb[13] = 0; // nickname builder 2 built
        $this->bb[14] = 0; // nickname builder 3 built
        $this->bb[15] = 0; // nickname builder 4 built
        $this->bb[16] = 0; // nickname builder 5 built
        $this->bb[17] = 0; // nickname builder 6 built
        $this->bb[18] = 0; // nickname builder 7 built      
        $this->bb[19] = 0; // nickname builder 8 built   
        $this->bb[20] = 0; // nickname builder 9 built
        $this->bb[21] = 0; // nickname builder 10 built
        
        $this->bb[22] = 0; // in which arena are the players
        
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "Popup")), 10);
        if (!file_exists($this->getDataFolder() . "config.yml")) {
            @mkdir($this->getDataFolder());
            file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("config.yml"));
        }
    }
    public function PlayerJoinEvent(PlayerJoinEvent $event){
        $p = $event->getPlayer();
        if((int)$this->bb[0] != 0){
            $p->close("", TextFormat::RED."The game has already begun!");
            return false;
        }
        $p->setNameTagVisible(false);
        $p->setGamemode(0);
        $p->teleport(new Position($this->getConfig()->get("Spawn")));
        if(count($this->getServer()->getOnlinePlayers()) >= 5){
            $this->getServer()->broadcastMessage(TextFormat::RED."Starting the game after 10 seconds!");
            $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "Start"]), 10 * 20 );
        } else {
            $p->sendMessage(TextFormat::GOLD.'You have joined the BuildBattle lineup..');
            $p->sendMessage(TextFormat::GOLD.'As the number of players reaches 10, you will start the game..');
        }
    }
    public function PlayerQuitEvent(PlayerQuitEvent $event){
        $event->getPlayer()->getInventory()->clearAll();
    }
    public function Start(){
        if(count($this->getServer()->getOnlinePlayers()) >= 10){
            $this->getServer()->broadcastMessage(TextFormat::RED."The start of the game was canceled. Someone left the server.");
        } else {
            $this->getServer()->broadcastMessage(TextFormat::RED."The game has begun!");
            $online = $this->getServer()->getOnlinePlayers();
            $online[0]->teleport(new Position($this->getConfig()->get("1")));
            $online[1]->teleport(new Position($this->getConfig()->get("2")));
            $online[2]->teleport(new Position($this->getConfig()->get("3")));
            $online[3]->teleport(new Position($this->getConfig()->get("4")));
            $online[4]->teleport(new Position($this->getConfig()->get("5")));
            $online[5]->teleport(new Position($this->getConfig()->get("6")));
            $online[6]->teleport(new Position($this->getConfig()->get("7")));
            $online[7]->teleport(new Position($this->getConfig()->get("8")));
            $online[8]->teleport(new Position($this->getConfig()->get("9")));
            $online[9]->teleport(new Position($this->getConfig()->get("10")));
           
            $this->bb[10] = $online[0]; // nickname builder 1 built
            $this->bb[11] = $online[1]; // nickname builder 2 built
            $this->bb[12] = $online[2]; // nickname builder 3 built
            $this->bb[13] = $online[3]; // nickname builder 4 built
            $this->bb[14] = $online[4]; // nickname builder 5 built
            $this->bb[15] = $online[5]; // nickname builder 6 built
            $this->bb[16] = $online[6]; // nickname builder 7 built
            $this->bb[17] = $online[7]; // nickname builder 8 built
            $this->bb[18] = $online[8]; // nickname builder 9 built
            $this->bb[19] = $online[9]; // nickname builder 10 built
            
            foreach($this->getServer()->getOnlinePlayers() as $p){
            
                $p->setGamemode(1);
            }
            $r = mt_rand(1,10);
            if($r == 1){
                $this->bb[1] = "Bridge";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a bridge within 5 minutes");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 4 * 60 * 20 );
            } elseif($r == 2){
                $this->bb[1] = "Computer";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a computer in 5 minutes");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 4 * 60 * 20 );
            } elseif($r == 3){
                $this->bb[1] = "Castle";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a castle within 5 minutes");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 4 * 60 * 20 );
            } elseif($r == 4){
                $this->bb[1] = "Tower of Archers";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a tower of archers, within 5 minutes");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 4 * 60 * 20 );
            } elseif($r == 5){
                $this->bb[1] = "Lamp";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a lamp within 2 minutes");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 1 * 60 * 20 );
            } elseif($r == 6){
                $this->bb[1] = "Нeadphone";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a headphone for 3 minutes");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 2 * 60 * 20 );
            } elseif($r == 7){
                $this->bb[1] = "Cartoon";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a Cartoon within 3 mintues");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 2 * 60 * 20 );
            } elseif($r == 8){
                $this->bb[1] = "Car";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a car within 5 mintues");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 4 * 60 * 20 );
            } elseif($r == 9){
                $this->bb[1] = "Airplane";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a airplane within 5 mintues ");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 4 * 60 * 20 );
            } elseif($r == 10){
                $this->bb[1] = "Shark";
                $this->getServer()->broadcastMessage(TextFormat::GOLD."Build a shark within 3 mintues");
                $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "min1"]), 2 * 60 * 20 );
            }
            $this->bb[0] = 1;
        }
    }
    public function Popup(){
        if($this->bb[0] = 1){
            $this->getServer()->broadcastPopup(TextFormat::GOLD."You have to build ".$this->bb[1]);
        }
    }
    public function min1(){
        $this->getServer()->broadcastMessage(TextFormat::GOLD."One minute left! Hurry up to complete");
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "second30"]), 30 * 20 );
    }
    public function second30(){
        $this->getServer()->broadcastMessage(TextFormat::GOLD."30 seconds left, build faster!");
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "finish"]), 30 * 20 );
    }
    public function finish(){
        $this->getServer()->broadcastMessage(TextFormat::GOLD."Times Up! Voting Time!");
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "a1"]), 20 * 20 );
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "a2"]), 40 * 20 );
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "a3"]), 60 * 20 );
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "a4"]), 80 * 20 );
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "a5"]), 100 * 20 );
        $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "stats"]), 120 * 20 );
    }
    public function a1(){
        foreach ($this->getServer()->getOnlinePlayers() as $p) {
            $p->setGamemode(0);
            $p->getInventory()->setItem(1, Item::get(35,5,1)); // OK
            $p->getInventory()->setItem(1, Item::get(35,4,1)); // Good
            $p->getInventory()->setItem(1, Item::get(35,14,1)); // Bad
            $p->teleport(new Position(100,100,100));
            $p->sendMessage(TextFormat::GOLD."This construction from the player ".$this->bb[7]);
            $p->sendMessage(TextFormat::GOLD."Vote for this build.");
            $p->sendMessage(TextFormat::GREEN."- green wool: great");
            $p->sendMessage(TextFormat::YELLOW."- yellow wool: normal");
            $p->sendMessage(TextFormat::RED."- red wool: bad");
            $this->bb[12] = "1";
        }
    }
    public function a2(){
        foreach ($this->getServer()->getOnlinePlayers() as $p) {
            $p->setGamemode(0);
            $p->getInventory()->setItem(1, Item::get(35,5,1)); // OK
            $p->getInventory()->setItem(1, Item::get(35,4,1)); // Good
            $p->getInventory()->setItem(1, Item::get(35,14,1)); // Bad
            $p->teleport(new Position(100,100,100));
            $p->sendMessage(TextFormat::GOLD."This Construction is made from the player ".$this->bb[8]);
            $p->sendMessage(TextFormat::GOLD."Vote for this build.");
            $p->sendMessage(TextFormat::GREEN."- green wool: great");
            $p->sendMessage(TextFormat::YELLOW."- yellow wool: normal");
            $p->sendMessage(TextFormat::RED."- red wool: bad");
            $this->bb[12] = "2";
        }
    }
    public function a3(){
        foreach ($this->getServer()->getOnlinePlayers() as $p) {
            $p->setGamemode(0);
            $p->getInventory()->setItem(1, Item::get(35,5,1)); // OK
            $p->getInventory()->setItem(1, Item::get(35,4,1)); // Good
            $p->getInventory()->setItem(1, Item::get(35,14,1)); // Bad
            $p->teleport(new Position(100,100,100));
            $p->sendMessage(TextFormat::GOLD."This Construction is made from the player  ".$this->bb[9]);
            $p->sendMessage(TextFormat::GOLD."Vote For this build.");
            $p->sendMessage(TextFormat::GREEN."- green wool: great");
            $p->sendMessage(TextFormat::YELLOW."- yellow wool: normal");
            $p->sendMessage(TextFormat::RED."- red wool: bad");
            $this->bb[12] = "3";
        }
    }
    public function a4(){
        foreach ($this->getServer()->getOnlinePlayers() as $p) {
            $p->setGamemode(0);
            $p->getInventory()->setItem(1, Item::get(35,5,1)); // OK
            $p->getInventory()->setItem(1, Item::get(35,4,1)); // Good
            $p->getInventory()->setItem(1, Item::get(35,14,1)); // Bad
            $p->teleport(new Position(100,100,100));
            $p->sendMessage(TextFormat::GOLD."This Construction is made from the player ".$this->bb[10]);
            $p->sendMessage(TextFormat::GOLD."Vote for this build.");
            $p->sendMessage(TextFormat::GREEN."- green wool: great");
            $p->sendMessage(TextFormat::YELLOW."- yellow wool: normal");
            $p->sendMessage(TextFormat::RED."- red wool: bad");
            $this->bb[12] = "4";
        }
    }
    public function a5(){
        foreach ($this->getServer()->getOnlinePlayers() as $p) {
            $p->setGamemode(0);
            $p->getInventory()->setItem(1, Item::get(35,5,1)); // OK
            $p->getInventory()->setItem(1, Item::get(35,4,1)); // Good
            $p->getInventory()->setItem(1, Item::get(35,14,1)); // Bad
            $p->teleport(new Position(100,100,100));
            $p->sendMessage(TextFormat::GOLD."This Construction is made from the player  ".$this->bb[11]);
            $p->sendMessage(TextFormat::GOLD."Vote for this build.");
            $p->sendMessage(TextFormat::GREEN."- green wool: great");
            $p->sendMessage(TextFormat::YELLOW."- yellow wool: normal");
            $p->sendMessage(TextFormat::RED."- red wool: bad");
            $this->bb[12] = "5";
        }
    }
    public function stats(){
        $stats = array((int)$this->bb[2], (int)$this->bb[3], (int)$this->bb[4], (int)$this->bb[5], (int)$this->bb[6]);
        $iterator = new \RecursiveArrayIterator(new \RecursiveArrayIterator($stats));
        $max = max(iterator_to_array($iterator, false));
        if((int)$this->bb[2] == $max){
            foreach($this->getServer()->getOnlinePlayers() as $p){
                $p->teleport(new Position($this->getConfig()->get("Spawn")));
                $p->getInventory()->addItem(Item::get(1,0,1));
                $p->getInventory()->clearAll();
            }
            $this->getServer()->broadcastMessage(TextFormat::RED."The BuildBattle Player Wins".$this->bb[7]);
        } elseif((int)$this->bb[3] == $max){
            foreach($this->getServer()->getOnlinePlayers() as $p){
                $p->teleport(new Position($this->getConfig()->get("Spawn")));
                $p->getInventory()->addItem(Item::get(1,0,1));
                $p->getInventory()->clearAll();
            }
            $this->getServer()->broadcastMessage(TextFormat::RED."The BuildBattle Player Wins ".$this->bb[8]);
        } elseif((int)$this->bb[4] == $max){
            foreach($this->getServer()->getOnlinePlayers() as $p){
                $p->teleport(new Position($this->getConfig()->get("Spawn")));
                $p->getInventory()->addItem(Item::get(1,0,1));
                $p->getInventory()->clearAll();
            }
            $this->getServer()->broadcastMessage(TextFormat::RED."The BuildBattle Player Wins  ".$this->bb[9]);
        } elseif((int)$this->bb[5] == $max){
            foreach($this->getServer()->getOnlinePlayers() as $p){
                $p->teleport(new Position($this->getConfig()->get("Spawn")));
                $p->getInventory()->addItem(Item::get(1,0,1));
                $p->getInventory()->clearAll();
            }
            $this->getServer()->broadcastMessage(TextFormat::RED."The BuildBattle Player Wins ".$this->bb[10]);
        } elseif((int)$this->bb[6] == $max){
            foreach($this->getServer()->getOnlinePlayers() as $p){
                $p->teleport(new Position($this->getConfig()->get("Spawn")));
                $p->getInventory()->addItem(Item::get(1,0,1));
                $p->getInventory()->clearAll();
            }
          $this->getServer()->broadcastMessage(TextFormat::RED."The BuildBattle Player Wins  ".$this->bb[11]);
        }
        $this->bb = array();       
        $this->bb[0] = 0; // is the game running
        $this->bb[1] = 0; // what you need to build
        
        $this->bb[2] = 0; // overall rating of 1 built
        $this->bb[3] = 0; // overall rating of 2 built
        $this->bb[4] = 0; // overall rating of 3 built
        $this->bb[5] = 0; // overall rating of 4 built
        $this->bb[6] = 0; // overall rating of 5 built
      
        $this->bb[7] = 0; // nickname builder 1 built
        $this->bb[8] = 0; // nickname builder 2 built
        $this->bb[9] = 0; // nickname builder 3 built       
        $this->bb[10] = 0; // nickname builder 4 built
        $this->bb[11] = 0; // nickname builder 5 built
      
        $this->bb[12] = 0; // in which arena are the players
    }
    public function PlayerItemHeldEvent(PlayerItemHeldEvent $event){
        $i = $event->getItem();
        $p = $event->getPlayer();
        if($i->getId() == 35 && $i->getDamage() == 5){
            $p->sendMessage(TextFormat::GREEN."You successfully left a voice!");
            $p->sendTip(TextFormat::GREEN."You successfully left a voice!");
            $event->setCancelled(true);
            if($this->bb[12] == "1"){
                $this->bb[2] = (int)$this->bb[2] + 3;
            } elseif($this->bb[12] == "2"){
                $this->bb[3] = (int)$this->bb[2] + 3;
            } elseif($this->bb[12] == "3"){
                $this->bb[4] = (int)$this->bb[2] + 3;
            } elseif($this->bb[12] == "4"){
                $this->bb[5] = (int)$this->bb[2] + 3;
            } elseif($this->bb[12] == "5"){
                $this->bb[6] = (int)$this->bb[2] + 3;
            }
            $event->getPlayer()->getInventory()->addItem(Item::get(1,0,1));
            $p->getInventory()->clearAll();
        } elseif($i->getId() == 35 && $i->getDamage() == 4){
            $p->sendMessage(TextFormat::YELLOW."You successfully left a voice!");
            $p->sendTip(TextFormat::YELLOW."You successfully left a voice!");
            $event->setCancelled(true);
            if($this->bb[12] == "1"){
                $this->bb[2] = (int)$this->bb[2] + 2;
            } elseif($this->bb[12] == "2"){
                $this->bb[3] = (int)$this->bb[2] + 2;
            } elseif($this->bb[12] == "3"){
                $this->bb[4] = (int)$this->bb[2] + 2;
            } elseif($this->bb[12] == "4"){
                $this->bb[5] = (int)$this->bb[2] + 2;
            } elseif($this->bb[12] == "5"){
                $this->bb[6] = (int)$this->bb[2] + 2;
            }
            $event->getPlayer()->getInventory()->addItem(Item::get(1,0,1));
            $p->getInventory()->clearAll();
        } elseif($i->getId() == 35 && $i->getDamage() == 14){
            $p->sendMessage(TextFormat::RED."You successfully left a voice!");
            $p->sendTip(TextFormat::RED."You successfully left a voice!");
            $event->setCancelled(true);
            if($this->bb[12] == "1"){
                $this->bb[2] = (int)$this->bb[2] + 1;
            } elseif($this->bb[12] == "2"){
                $this->bb[3] = (int)$this->bb[2] + 1;
            } elseif($this->bb[12] == "3"){
                $this->bb[4] = (int)$this->bb[2] + 1;
            } elseif($this->bb[12] == "4"){
                $this->bb[5] = (int)$this->bb[2] + 1;
            } elseif($this->bb[12] == "5"){
                $this->bb[6] = (int)$this->bb[2] + 1;
            }
            $event->getPlayer()->getInventory()->addItem(Item::get(1,0,1));
            $p->getInventory()->clearAll();
        }
    }
    public function BlockBreakEvent(BlockBreakEvent $event){
        if($event->getPlayer()->getGamemode() != 1){
            $event->setCancelled(true);
        } elseif($event->getBlock()->getId() == 20 && !$event->getPlayer()->isOp()){
            $event->setCancelled(true);
        }
    }
    public function BlockPlaceEvent(BlockPlaceEvent $event){
        if($event->getPlayer()->getGamemode() != 1){
            $event->setCancelled(true);
        } elseif($event->getBlock()->getId() == 20 && !$event->getPlayer()->isOp()){
            $event->setCancelled(true);
        }
    }
    public function PlayerGameModeChangeEvent(PlayerGameModeChangeEvent $event){
        $event->getPlayer()->getInventory()->addItem(Item::get(1,0,1));
        $event->getPlayer()->getInventory()->clearAll();
    }
}
