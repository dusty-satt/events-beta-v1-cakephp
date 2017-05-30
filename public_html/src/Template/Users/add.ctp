
<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('role', [
            'options' => ['admin' => 'Admin', 'host' => 'Host', 'guest' => 'Guest']
        ]) ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>
