<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

$body = [
    'title' => 'Notification',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- CodeMirror -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/theme/monokai.css">
<!-- ckeditor -->
<script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<!-- CodeMirror -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/css/css.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/xml/xml.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
<script>
CKEDITOR.replace("content");
</script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__."/../../../libs/sendEmail.php");
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SendNoti'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Kh??ng ???????c d??ng ch???c n??ng n??y v?? ????y l?? trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $content = $_POST['content'];
    $title = check_string($_POST['title']);
 

    if (empty($_POST['listUser'])) {
        foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `banned` = 0 ") as $user) {
            $isInsert = $CMSNT->insert("notifications", [
                'user_id'   => $user['id'],
                'title'     => $title,
                'content'   => $content,
                'sender'    => 'Staff',
                'timeago'   => time(),
                'createdate'    => gettime(),
                'status'    => 0
            ]);
        }
    } else {
        foreach ($_POST['listUser'] as $user) {
            $user = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$user' ");
            $isInsert = $CMSNT->insert("notifications", [
                'user_id'   => $user['id'],
                'title'     => $title,
                'content'   => $content,
                'sender'    => 'Staff',
                'timeago'   => time(),
                'createdate'    => gettime(),
                'status'    => 0
            ]);
        }
    }
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "G???i th??ng b??o ?????n th??nh vi??n."
        ]);
        die('<script type="text/javascript">if(!alert("G???i th??nh c??ng !")){location.href = "";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("G???i th???t b???i !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notification</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notification</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bell mr-1"></i>
                                G???I TH??NG B??O ?????N TH??NH VI??N
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
                                    <label>Ch???n th??nh vi??n nh???n th??ng b??o</label>
                                    <select class="select2bs4" name="listUser[]" multiple="multiple" data-placeholder="Kh??ng ch???n ????? g???i to??n th??nh vi??n"
                                        style="width: 100%;">
                                        <?php foreach ($CMSNT->get_list("SELECT * FROM `users` ") as $user) {?>
                                        <option value="<?=$user['id'];?>">ID: <?=$user['id'];?> - Username: <?=$user['username'];?> - Email: <?=$user['email'];?> - Phone: <?=$user['phone'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ti??u ?????</label>
                                    <input class="form-control" type="text" placeholder="Nh???p ti??u ????? th??ng b??o" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">N???i dung</label>
                                    <textarea class="form-control" placeholder="Nh???p n???i dung chi ti???t th??ng b??o" name="content" required></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SendNoti" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-paper-plane mr-1"></i>G???i Ngay</button>
                            </div>
                        </form>
                    </div>
                    <p>Xem h?????ng d???n s??? d???ng t???i ????y: <a target="_blank" href="https://www.youtube.com/watch?v=ybIf2t2JqBo&list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW&index=4">https://www.youtube.com/watch?v=ybIf2t2JqBo&list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW&index=4</a></p>
                </section>
            </div>
        </div>
    </div>
</div>


<?php
require_once(__DIR__.'/footer.php');
?>