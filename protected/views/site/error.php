<?php $this->pageTitle = 'Error - '; ?>
<div class="container main">
    <h1 align="center">Error <?php echo $code; ?></h1>
    <div class="error" align="center">
    <?php echo CHtml::encode($message); ?>
    </div>
    <div align="center"><a href="/">Home</a></div>
</div>