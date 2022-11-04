<?php if ($nameChart->getFirstName()): ?>
<p class="text-center text-dark">First Name</p>
<table class="table table-bordered">
    <tr>
    <?php foreach($nameChart->getFirstName() as $nameCharacterValue): ?>
        <td><?=$nameCharacterValue->getCharacter()?></td>
    <?php endforeach; ?>
    </tr>
    <tr>
    <?php foreach($nameChart->getFirstName() as $nameCharacterValue): ?>
        <td><?=$nameCharacterValue->getNumber()?></td>
    <?php endforeach; ?>
    </tr>
</table>
<?php endif; ?>
<?php if ($nameChart->getMiddleName()): ?>
    <p class="text-center text-dark">Middle Name</p>
    <table class="table table-bordered">
        <tr>
            <?php foreach($nameChart->getMiddleName() as $nameCharacterValue): ?>
                <td><?=$nameCharacterValue->getCharacter()?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach($nameChart->getMiddleName() as $nameCharacterValue): ?>
                <td><?=$nameCharacterValue->getNumber()?></td>
            <?php endforeach; ?>
        </tr>
    </table>
<?php endif; ?>
<?php if ($nameChart->getLastName()): ?>
    <p class="text-center text-dark">Last Name</p>
    <table class="table table-bordered">
        <tr>
            <?php foreach($nameChart->getLastName() as $nameCharacterValue): ?>
                <td><?=$nameCharacterValue->getCharacter()?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach($nameChart->getLastName() as $nameCharacterValue): ?>
                <td><?=$nameCharacterValue->getNumber()?></td>
            <?php endforeach; ?>
        </tr>
    </table>
<?php endif; ?>
