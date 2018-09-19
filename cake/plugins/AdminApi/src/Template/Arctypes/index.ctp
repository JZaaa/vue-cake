<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $arctypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Arctype'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="arctypes index large-9 medium-8 columns content">
    <h3><?= __('Arctypes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('level') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sort') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isshow') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keywords') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('href') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arctypes as $arctype): ?>
            <tr>
                <td><?= $this->Number->format($arctype->id) ?></td>
                <td><?= h($arctype->name) ?></td>
                <td><?= $arctype->has('parent_arctype') ? $this->Html->link($arctype->parent_arctype->name, ['controller' => 'Arctypes', 'action' => 'view', $arctype->parent_arctype->id]) : '' ?></td>
                <td><?= $this->Number->format($arctype->level) ?></td>
                <td><?= $this->Number->format($arctype->sort) ?></td>
                <td><?= $this->Number->format($arctype->type) ?></td>
                <td><?= h($arctype->image) ?></td>
                <td><?= $this->Number->format($arctype->isshow) ?></td>
                <td><?= h($arctype->keywords) ?></td>
                <td><?= h($arctype->description) ?></td>
                <td><?= h($arctype->href) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $arctype->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $arctype->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $arctype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $arctype->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
