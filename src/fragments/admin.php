<div class="container_admin">
    
    <form role="form" method="post" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload">

        <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
        <input type="file" name="newfile">

        <input type="submit" name="submit" value="Upload">

    </form>
    
</div>