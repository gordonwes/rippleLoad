<div class="container_admin">
    <form role="form" method="post" action="<?= $baseUrl ?>/upload" enctype="multipart/form-data">

        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" name="newfile">

        <input type="submit" name="submit" value="Upload">

    </form>
</div>