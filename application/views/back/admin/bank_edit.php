<?php
foreach ($bank_data as $data) {
    ?>
    <div class="tab-pane fade active in" id="edit">
        <?php
        echo form_open(base_url() . 'index.php/admin/bank/update/' . $data['id'], array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'bank_edit',
            'enctype' => 'multipart/form-data'
        ));
        ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                    <?php echo translate('bank_name'); ?>
                </label>
                <div class="col-sm-6">
                    <input type="text" name="bank_name" id="demo-hor-1"
                           class="form-control required" value="<?= $data['bank_name'] ?>"
                           placeholder="<?php echo translate('bank_name'); ?>">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                    <?php echo translate('bank_number'); ?>
                </label>
                <div class="col-sm-6">
                    <input type="text" name="bank_number" id="demo-hor-1"
                           class="form-control required" value="<?= $data['bank_number'] ?>" placeholder="<?php echo translate('bank_number'); ?>">
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                    <?php echo translate('bank_our'); ?>
                </label>
                <div class="col-sm-6">
                    <input type="text" name="bank_our" id="demo-hor-1"
                           class="form-control required" value="<?= $data['bank_our'] ?>" placeholder="<?php echo translate('bank_our'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                    <?php echo translate('bank_branch'); ?>
                </label>
                <div class="col-sm-6">
                    <input type="text" name="bank_branch" id="demo-hor-1"
                           class="form-control required" value="<?= $data['bank_branch'] ?>" placeholder="<?php echo translate('bank_branch'); ?>">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                    <?php echo translate('bank_detail'); ?>
                </label>
                <div class="col-sm-6">
                    <input type="text" name="bank_detail" id="demo-hor-1"
                           class="form-control required" value="<?= $data['bank_detail'] ?>"
                           placeholder="<?php echo translate('bank_detail'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1">
                    <?php echo translate('bank_image'); ?>
                </label>
                <?php
                $images = $this->crud_model->file_view('bank', $data['id'], '', '', 'thumb', 'src', '', 'all');
                ?>
                <div class="col-sm-6">
					<span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?>
                        <input type="file" multiple name="images" onchange="preview(this);" id="demo-hor-12"
                               class="form-control">
						</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-xs-8">
						<span id="previewImg" style="padding: 10px">
							<img class="img-thumbnail" width="250" src="<?php echo $images; ?>" alt="<?= $data['bank_name'] ?>">
						</span>
                </div>
            </div>


        </div>
        </form>
    </div>
    <?php
}
?>

<script>
    $(document).ready(function () {
        $("form").submit(function (e) {
            return false;
        });
    });

    window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<img width='250' src='" + e.target.result + "' class='img-thumbnail'>");
                }
            });
        }
    }

</script>