<?php
if (count(BACKGROUND_COLOR) > 1) {
    $background_property = 'linear-gradient('.implode(', ', BACKGROUND_COLOR).')';
} else {
    $background_property = BACKGROUND_COLOR[0];
}
?>
<style>
    :root {
        --background-property: <?=$background_property?>;
        --btn-bg-color: <?=BTN_BG_COLOR?>;
        --btn-text-color: <?=BTN_TEXT_COLOR?>;
        --active-btn-bg-color: <?=ACTIVE_BTN_BG_COLOR?>;
    }
</style>
