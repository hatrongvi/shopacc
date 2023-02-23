<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Cấu hình Thuê SIM',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
]; 
$body['header'] = '
    <!-- Bootstrap Switch -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- ckeditor -->
    <script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- Select2 -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
    <script>
    $(function () {
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch("state", $(this).prop("checked"));
          })
        $(".select2").select2()
        $(".select2bs4").select2({
            theme: "bootstrap4"
        });
    });
    </script>
    <!-- bs-custom-file-input -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(function () {
    bsCustomFileInput.init();
    });
    </script> 
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
    if (isset($_POST['SaveSettings'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        // if(checkAddon(11521) != true){
        //     die('<script type="text/javascript">if(!alert("Bạn cần mua Addon này mới có thể sử dụng !")){window.history.back().location.reload();}</script>');
        // }
        foreach ($_POST as $key => $value) {
            $CMSNT->update("settings", array(
                'value' => $value
            ), " `name` = '$key' ");
        }
        die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
    } ?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cấu hình Thuê SIM</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin('home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cấu hình Thuê SIM</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH API THUÊ SIM
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <?php if(checkAddon(11621) == true):?>
                                    <select class="form-control select2bs4" name="status_thuesim">
                                        <option <?=$CMSNT->site('status_thuesim') == 1 ? 'selected' : '';?> value="1">ON
                                        </option>
                                        <option <?=$CMSNT->site('status_thuesim') == 0 ? 'selected' : '';?> value="0">
                                            OFF
                                        </option>
                                    </select>
                                    <?php else:?>
                                    <div class="alert alert-danger" role="alert">
                                        <div class="iq-alert-text">Bạn chưa kích hoạt Addon này!</div>
                                    </div>
                                    <?php endif?>

                                </div>
                                <div class="form-group">
                                    <label>Server</label>
                                    <select class="form-control select2bs4" name="server_thuesim">
                                        <?php if(checkAddon(11621) == true):?>
                                        <option
                                            <?=$CMSNT->site('server_thuesim') == 'chothuesimcode.com' ? 'selected' : '';?>
                                            value="chothuesimcode.com">chothuesimcode.com
                                        </option>
                                        <?php endif?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Token hoặc API Key</label>
                                    <div class="row">
                                        <div class="col-lg-12 mr-1 mb-3">
                                            <textarea class="form-control" rows="1" name="token_thuesim"
                                                required><?=$CMSNT->site('token_thuesim');?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cập nhật giá tự động theo %</label>
                                    <input type="text" class="form-control" name="ck_rate_thuesim"
                                        value="<?=$CMSNT->site('ck_rate_thuesim');?>">
                                    <i>SET thành 0 để tắt chức năng này.</i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý</label>
                                    <textarea id="notice_thuesim"
                                        name="notice_thuesim"><?=$CMSNT->site('notice_thuesim');?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-question-circle mr-1"></i>
                                HƯỚNG DẪN CẤU HÌNH
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                             
                            <p>Vui lòng khắc phục hết các Alert phía dưới mới có thể sử dụng tính năng này.</p>
                        </div>
                    </div>
                    <?php if($CMSNT->site('token_thuesim') == ''):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Bạn cần cấu hình Token mới có thể sử dụng chức năng này.
                    </div>
                    <?php endif?>
                    <?php if(time() - $CMSNT->site('check_time_cron_service_otp_cron') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a
                            href=" <?=base_url('cron/service-otp/create.php');?>"
                            target="_blank"><?=base_url('cron/service-otp/create.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if(time() - $CMSNT->site('check_time_cron_service_otp_history') >= 120):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng thực hiện <b>CRON JOB</b> liên kết: <a
                            href=" <?=base_url('cron/service-otp/history.php');?>"
                            target="_blank"><?=base_url('cron/service-otp/history.php');?></a>
                    </div>
                    <?php endif?>
                    <?php if(checkAddon(11621) != true):?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Vui lòng kích hoạt Addon Tích hợp thuê OTP mới có thể sử dụng.
                    </div>
                    <?php endif?>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẬP NHẬT GIÁ DỊCH VỤ
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                <h5>Lưu ý</h5>
                                <ul>
                                    <li>Vui lòng chỉnh Cập nhật giá tự động về 0 nếu bạn muốn tuỳ chỉnh giá từng dịch
                                        vụ.</li>
                                </ul>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="2%">ID</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `service_otp` ORDER BY id DESC  ") as $row) {?>
                                        <tr onchange="updateForm(`<?=$row['id'];?>`)">
                                            <td><?=$row['id'];?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="mb-2">
                                                            <select class="form-control select2bs4"
                                                                id="status<?=$row['id'];?>" required>
                                                                <option <?=$row['status'] == 1 ? 'selected' : '';?>
                                                                    value="1">ON</option>
                                                                <option <?=$row['status'] == 0 ? 'selected' : '';?>
                                                                    value="0">OFF</option>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="input-group col-6 mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ID API</span>
                                                                </div>
                                                                <textarea readonly rows="1"
                                                                    class="form-control"><?=$row['id_api'];?></textarea>
                                                            </div>
                                                            <div class="input-group col-6 mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Server</span>
                                                                </div>
                                                                <textarea readonly rows="1"
                                                                    class="form-control"><?=$row['server'];?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Tên dịch vụ gốc</span>
                                                            </div>
                                                            <textarea rows="1" id="name_api<?=$row['id'];?>"
                                                                class="form-control"><?=$row['name_api'];?></textarea>
                                                        </div>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Tên dịch vụ</span>
                                                            </div>
                                                            <textarea rows="1" id="name<?=$row['id'];?>"
                                                                class="form-control"><?=$row['name'];?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Giá bán</span>
                                                            </div>
                                                            <textarea rows="1" id="price<?=$row['id'];?>"
                                                                class="form-control"><?=$row['price'];?></textarea>
                                                        </div>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Giá vốn</span>
                                                            </div>
                                                            <textarea rows="1" id="price_api<?=$row['id'];?>"
                                                                class="form-control"><?=$row['price_api'];?></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>

<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/updateForm.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            table: 'rate_service_otp',
            id: id,
            name: $("#name" + id).val(),
            name_api: $("#name_api" + id).val(),
            price_api: $("#price_api" + id).val(),
            price: $("#price" + id).val(),
            status: $("#status" + id).val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            location.reload();
        }
    });
}
</script>


<script>
CKEDITOR.replace("notice_thuesim");
$(function() {
    $('#datatable2').DataTable();
});
</script>