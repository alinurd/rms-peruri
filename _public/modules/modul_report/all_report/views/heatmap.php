<style>
	div {
    -ms-overflow-style: none;  /* Untuk Internet Explorer 10+ */
    scrollbar-width: none;      /* Untuk Firefox */
}

div::-webkit-scrollbar {     /* Untuk Webkit (Chrome, Safari) */
    display: none;
}

</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <div class="profile-info col-md-4">
                <div class="x_content text-center" style="max-width: 100%;" id="mapping_inherent">
                    <?=$mapping['inherent'];?>
                </div>
            </div>
            <div class="profile-info col-md-4">
                <div class="x_content text-center" id="mapping_current" style="max-width: 100%;">
                    <?=$mapping['current'];?>
                </div>
            </div>
            <div class="profile-info col-md-4">
                <div class="x_content text-center" style="max-width: 100%;" id="mapping_residual">
                    <?= $mapping['residual']; ?>
                </div>
            </div>
        </section>
    </div>
</div>