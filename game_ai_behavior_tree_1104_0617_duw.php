<?php
// 代码生成时间: 2025-11-04 06:17:13
// Define the base Behavior Node class
abstract class BehaviorNode {
    abstract public function evaluate($context);
}

// Define the composite node which will execute children in sequence
class CompositeNode extends BehaviorNode {
    protected $children;

    public function __construct(array $children) {
        $this->children = $children;
    }

    public function evaluate($context) {
        foreach ($this->children as $child) {
            $result = $child->evaluate($context);
            if ($result !== null) {
                return $result;
            }
        }
        return null;
    }
}

// Define the decorator node which adds behavior to the child node
class DecoratorNode extends BehaviorNode {
    protected $child;

    public function __construct(BehaviorNode $child) {
        $this->child = $child;
    }

    public function evaluate($context) {
        return $this->child->evaluate($context);
    }
}

// Define the condition node which returns success or failure
class ConditionNode extends BehaviorNode {
    protected $condition;

    public function __construct(callable $condition) {
        $this->condition = $condition;
    }

    public function evaluate($context) {
        return ($this->condition($context)) ? 'success' : 'failure';
    }
}

// Define the action node which performs an action
class ActionNode extends BehaviorNode {
    protected $action;

    public function __construct(callable $action) {
        $this->action = $action;
    }

    public function evaluate($context) {
        $this->action($context);
        return 'success';
    }
}

// Define the context class to hold game state information
class GameContext {
    public $enemyHealth;
    public $playerHealth;
    public $playerEnergy;

    public function __construct($enemyHealth, $playerHealth, $playerEnergy) {
        $this->enemyHealth = $enemyHealth;
        $this->playerHealth = $playerHealth;
        $this->playerEnergy = $playerEnergy;
    }
}

// Define a simple behavior tree that decides whether to attack or defend
class AttackDefendBehaviorTree {
    public function buildTree() {
        $attack = new ActionNode(function ($context) {
            echo "Attacking enemy!
";
            // Simulate the attack action
            if ($context->enemyHealth > 0) {
                $context->enemyHealth -= 10;
            }
        });

        $defend = new ActionNode(function ($context) {
            echo "Defending!
";
            // Simulate the defense action
            if ($context->playerHealth < 100) {
                $context->playerHealth += 5;
            }
        });

        $enemyWeak = new ConditionNode(function ($context) {
            return $context->enemyHealth < 50;
        });

        $playerLowHealth = new ConditionNode(function ($context) {
            return $context->playerHealth < 50;
        });

        $root = new CompositeNode([
            // If enemy is weak, attack
            new DecoratorNode(new ConditionNode(function ($context) {
                return $context->enemyHealth > 0;
            })),
            $enemyWeak,
            $attack,
            // If player is low on health, defend
            $playerLowHealth,
            $defend,
            // If all else fails, attack
            $attack
        ]);

        return $root;
    }
}

// Usage example
$tree = new AttackDefendBehaviorTree();
$rootNode = $tree->buildTree();
$context = new GameContext(80, 75, 100);
$result = $rootNode->evaluate($context);
