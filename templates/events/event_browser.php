<div clase="viewer">
    <div class="browser">
        <div id="directoryContent" class="contents">&nbsp;</div>
    </div>
    <div class="preview">
        <img id="imagePreview" class="imagePreview" />
        <div id="previewName" class="text"></div>
        <form id="deleteForm" class="general_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?0' ?>">
            <button type="submit" class="btn_large" id="action"/>
        </form>
    </div>
</div>