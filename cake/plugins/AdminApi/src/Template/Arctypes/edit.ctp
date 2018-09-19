<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $arctype
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $arctype->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $arctype->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Arctypes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parent Arctypes'), ['controller' => 'Arctypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Arctype'), ['controller' => 'Arctypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="arctypes form large-9 medium-8 columns content">
    <?= $this->Form->create($arctype) ?>
    <fieldset>
        <legend><?= __('Edit Arctype') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('parent_id', ['options' => $parentArctypes, 'empty' => true]);
            echo $this->Form->control('level');
            echo $this->Form->control('sort');
            echo $this->Form->control('type');
            echo $this->Form->control('image');
            echo $this->Form->control('isshow');
            echo $this->Form->control('keywords');
            echo $this->Form->control('description');
            echo $this->Form->control('href');
            echo $this->Form->control('enable_columns');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
