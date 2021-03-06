<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $arctype
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Arctype'), ['action' => 'edit', $arctype->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Arctype'), ['action' => 'delete', $arctype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $arctype->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Arctypes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Arctype'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Arctypes'), ['controller' => 'Arctypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Arctype'), ['controller' => 'Arctypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Arctypes'), ['controller' => 'Arctypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Arctype'), ['controller' => 'Arctypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="arctypes view large-9 medium-8 columns content">
    <h3><?= h($arctype->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($arctype->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Arctype') ?></th>
            <td><?= $arctype->has('parent_arctype') ? $this->Html->link($arctype->parent_arctype->name, ['controller' => 'Arctypes', 'action' => 'view', $arctype->parent_arctype->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($arctype->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Keywords') ?></th>
            <td><?= h($arctype->keywords) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($arctype->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Href') ?></th>
            <td><?= h($arctype->href) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($arctype->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Level') ?></th>
            <td><?= $this->Number->format($arctype->level) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sort') ?></th>
            <td><?= $this->Number->format($arctype->sort) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= $this->Number->format($arctype->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Isshow') ?></th>
            <td><?= $this->Number->format($arctype->isshow) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Enable Columns') ?></h4>
        <?= $this->Text->autoParagraph(h($arctype->enable_columns)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Arctypes') ?></h4>
        <?php if (!empty($arctype->child_arctypes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Level') ?></th>
                <th scope="col"><?= __('Sort') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Isshow') ?></th>
                <th scope="col"><?= __('Keywords') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Href') ?></th>
                <th scope="col"><?= __('Enable Columns') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($arctype->child_arctypes as $childArctypes): ?>
            <tr>
                <td><?= h($childArctypes->id) ?></td>
                <td><?= h($childArctypes->name) ?></td>
                <td><?= h($childArctypes->parent_id) ?></td>
                <td><?= h($childArctypes->level) ?></td>
                <td><?= h($childArctypes->sort) ?></td>
                <td><?= h($childArctypes->type) ?></td>
                <td><?= h($childArctypes->image) ?></td>
                <td><?= h($childArctypes->isshow) ?></td>
                <td><?= h($childArctypes->keywords) ?></td>
                <td><?= h($childArctypes->description) ?></td>
                <td><?= h($childArctypes->href) ?></td>
                <td><?= h($childArctypes->enable_columns) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Arctypes', 'action' => 'view', $childArctypes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Arctypes', 'action' => 'edit', $childArctypes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Arctypes', 'action' => 'delete', $childArctypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childArctypes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Articles') ?></h4>
        <?php if (!empty($arctype->articles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Arctype Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Shorttitle') ?></th>
                <th scope="col"><?= __('Color') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Keywords') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Pubdate') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Autoimage') ?></th>
                <th scope="col"><?= __('Tag') ?></th>
                <th scope="col"><?= __('Isshow') ?></th>
                <th scope="col"><?= __('Istop') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Url') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($arctype->articles as $articles): ?>
            <tr>
                <td><?= h($articles->id) ?></td>
                <td><?= h($articles->arctype_id) ?></td>
                <td><?= h($articles->title) ?></td>
                <td><?= h($articles->shorttitle) ?></td>
                <td><?= h($articles->color) ?></td>
                <td><?= h($articles->description) ?></td>
                <td><?= h($articles->keywords) ?></td>
                <td><?= h($articles->content) ?></td>
                <td><?= h($articles->pubdate) ?></td>
                <td><?= h($articles->image) ?></td>
                <td><?= h($articles->autoimage) ?></td>
                <td><?= h($articles->tag) ?></td>
                <td><?= h($articles->isshow) ?></td>
                <td><?= h($articles->istop) ?></td>
                <td><?= h($articles->user_id) ?></td>
                <td><?= h($articles->url) ?></td>
                <td><?= h($articles->created) ?></td>
                <td><?= h($articles->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Articles', 'action' => 'view', $articles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Articles', 'action' => 'edit', $articles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Articles', 'action' => 'delete', $articles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
