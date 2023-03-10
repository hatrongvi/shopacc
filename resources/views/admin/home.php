<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Dashboard',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
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
require_once(__DIR__.'/../../../models/is_license.php');

function where_not_admin($type){
    global $CMSNT;
    $where_not_admin = "";
    foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `admin` = 1 ") as $qw) {
        $where_not_admin .= " `$type` != '".$qw['id']."' AND";
    }
    return $where_not_admin;
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?=base_url_admin('addons');?>" type="button" class="btn btn-primary"><i class="fas fa-puzzle-piece mr-1"></i>C???A H??NG ADDONS</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h5>G???i qu?? kh??ch h??ng c???a <b>CMSNT</b></h5>
                <ul>
                    <li>Qu?? kh??ch vui l??ng tham gia nh??m Zalo c???a CMSNT ????? n???m b???t th??ng tin c???p nh???t chi ti???t c???a s???n
                        ph???m, lu??n lu??n nh???n ???????c c??c th??ng b??o m???i nh???t v??? CMSNT ????? t???i ??u nh???t trong qu?? tr??nh ho???t
                        ?????ng.</li>
                    <li>Qu?? kh??ch tham gia nh??m nh???n th??ng tin th??ng b??o t???i ????y: <a target="_blank"
                            href="https://zalo.me/g/idapcx933">https://zalo.me/g/idapcx933</a></li>
                    <li>Qu?? kh??ch tham gia nh??m t??m ki???m ngu???n t???i ????y: <a target="_blank"
                            href="https://zalo.me/g/eululb377">https://zalo.me/g/eululb377</a></li>
                    <li>Inbox ngay cho CMSNT ????? ???????c duy???t tham gia nh??m, ch??? ??p d???ng cho qu?? kh??ch h??ng mua ch??nh ch???
                        t???i <a target="_blank" href="https://cmsnt.vn/">CMSNT.CO - CMSNT.VN</a></li>
                    <li>Ch??ng t??i ch???m d???t h??? tr??? n???u ph??t hi???n b???n crack m?? ngu???n, addon c???a ch??ng t??i ????? d??ng l???u n??.</li>
                </ul>
            </div>
            <div class="alert alert-dark">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>Phi??n b???n hi???n t???i: <span style="color: yellow;font-size:25px;"><?=$config['version'];?></span></b>
                <ul>
                    <li>Chi ti???t c???p nh???t vui l??ng xem t???i <a target="_blank" href="https://zalo.me/g/idapcx933">????y</a> (ch??? ??p d???ng cho kh??ch h??ng mua ch??nh h??ng t???i CMSNT.CO)</li>
                    <!-- <li>29/08/2022: Th??m m?? QR cho n???p ti???n server 2.</li>
                    <li>17/08/2022: Tu??? ch???nh s??? l?????ng ???? b??n t???ng s???n ph???m trong edit s???n ph???m.</li>
                    <li>15/08/2022: Tu??? ch???n th??? t??? mua t???ng s???n ph???m.</li>
                    <li>14/08/2022: Nick n??o check live g???n nh???t s??? ??u ti??n b??n tr?????c thay v?? nick n??o th??m tr?????c b??n tr?????c.</li>
                    <li>13/08/2022: Fix 1 s??? bill kh??ng Auto khi d??ng Server 2.</li>
                    <li>06/08/2022; Fix Crypto.</li>
                    <li>01/08/2022: Tu??? ch???nh ???n s???n ph???m khi h???t t??i kho???n.</li>
                    <li>31/07/2022: Update tu??? ch???nh giao d???ch ???o t???i <b>C??i ?????t</b> -> <b>Giao d???ch ???o</b>.</li>
                    <li>29/07/2022: Tu??? ch???nh tr???ng th??i m???c ?????nh khi th??m s???n ph???m API.</li>
                    <li>23/07/2022: Th??m n??t Login user, th???ng k?? l???i nhu???n khi ?????u API.</li> -->
                    <!-- <li>23/07/2022: Th??m ch???c n??ng n???p ti???n t??? ?????ng qua Crypto.</li>
                    <li>21/07/2022: Th??m Tu??? ch???n t??? ?????ng c???p t??n s???n ph???m API, th??m gi?? v???n cho ????n h??ng API ????? xem l???i nhu???n khi ?????u API.</li>
                    <li>19/07/2022: Th??m tu??? ch???nh ON/OFF thay password ?????nh k???.</li>
                    <li>17/07/2022: Th??m ??i???u ki???n gi?? tr??? ????n h??ng ???????c d??ng m?? gi???m gi?? (<a href="<?=base_url_admin('coupon-list');?>"><?=base_url_admin('coupon-list');?></a>)</li>
                    <li>16/07/2022: Th??m ch???c n??ng ti???p th??? li??n k???t (affiliates), update th??m ch???c n??ng k???t n???i API.</li>
                    <li>10/07/2022: C???p nh???t ch???c n??ng k???t n???i API (<a href="<?=base_url_admin('connect-api');?>"><?=base_url_admin('connect-api');?></a>).</li> -->
                    <!-- <li>07/07/2022: T??ng t???c ????? check live th??m, tu??? ch???n ???n hi???n menu kh??c.</li>
                    <li>07/07/2022: Update nhi???u qu?? n??n kh??ng nh??? update th??? g??.</li>
                    <li>04/07/2022: Fix l???i xo?? t??i kho???n SLL khi t??ch ch???n.</li>
                    <li>01/07/2022: Xo?? l???c ?????nh d???ng t??i kho???n khi Import b???ng API.</li> -->
                    <!-- <li>01/06/2022: Hi???n th??? th???ng k?? n???p ti???n Server2 v??o T???ng ti???n n???p.</li> -->
                    <!-- <li>25/05/2022: Fix Auto TPBank.</li>
                    <li>24/05/2022: T??ng t???c ????? Auto MBBank (vui l??ng theo d??i th??m).</li>
                    <li>23/05/2022: Fix auto bank server2.</li>
                    <li>15/05/2022: ????? tr???ng Flag ????? kh??ng hi???n qu???c gia s???n ph???m.</li>
                    <li>13/05/2022: Fix hi???n th??? ghi ch?? Paypal.</li>
                    <li>08/05/2022: Th??m ch???c n??ng ON/OFF duy???t th??nh vi??n khi ????ng k?? (c???u h??nh trong c??i ?????t -> th??ng tin chung).</li>
                    <li>08/05/2022: Th??m ch???c n??ng B???o M???t cho Admin (c???u h??nh trong b???o m???t).</li>
                    <li>07/05/2022: Th??m Addon b??n Fanpage/Group (tr??? ph??), edit hi???n th??? chi ti???t ????n h??ng.</li>
                    <li>03/05/2022: T??ng s??? l?????ng hi???n th??? table.</li>
                    <li>01/05/2022: Th??m ch???c n??ng b??n T????ng T??c (mi???n ph??).</li> -->
                    <!-- <li>26/04/2022: T???i ??u load th???ng k??, th??m addon s??? l?????ng ???? b??n ???o (tr??? ph??).</li>
                    <li>22/04/2022: Th??m n??t reset top n???p ti???n, fix l???i check live fb.</li>
                    <li>21/04/2022: Fix l???i hi???n th??? d???ch ??? v??i n??i, ??i???u ch???nh gi?? tr??? giao d???ch ???o.</li>
                    <li>21/04/2022: Fix t??ng t??? l??? ch??nh x??c API Check Live Facebook.</li>
                    <li>21/04/2022: Thay ???nh n??n Login, Register trong Admin</li>
                    <li>19/04/2022: Th??m Addon N???p Ti???n Server 2 (n???p ti???n b???ng n???i dung + id, t??nh n??ng tr??? ph??).</li>
                    <li>19/04/2022: ???n t??i kho???n Admin kh???i TOP MONEY.</li>
                    <li>18/04/2022: Update tu??? ch???nh gi???i h???n mua t???i thi???u v?? t???i ??a.</li>
                    <li>13/04/2022: Xu???t d??? li???u sang Excel (CSV).</li>
                    <li>12/04/2022: Th??m B???ng X???p H???ng N???p Ti???n (tr??? ph??).</li> -->
                    <!-- <li>09/04/2022: Th??m giao di???n b??n s???n ph???m Template 4 (tr??? ph??).</li>
                    <li>09/04/2022: Th??m s???n ph???m g???i ??.</li>
                    <li>08/04/2022: Fix l???i www Addons.</li>
                    <li>07/04/2022: Th??m t??nh n??ng t??? t???o giao d???ch ???o (tr??? ph??).</li>
                    <li>07/04/2022: Th??m giao di???n b??n s???n ph???m Template 3 (tr??? ph??).</li>
                    <li>07/04/2022: Th??m l???ch s??? n???p ti???n g???n ????y trong trang kh??ch h??ng.</li>
                    <li>06/04/2022: Th??m giao di???n hi???n th??? s???n ph???m, tu??? ch???nh on/off rating.</li>
                    <li>05/04/2022: Th??m t??nh n??ng <b>Xo?? ????n H??ng</b></li>
                    <li>05/04/2022: T??nh n??ng xo?? t??i kho???n h???t h???n d??nh cho hotmail, proxy (tu??? ch???nh trong edit s???n ph???m).</li>
                    <li>02/04/2022: Th??m ch???c n??ng Promotion.</li> -->
                    <!-- <li>30/03/2022: Thay ?????i FONT website trong <b>C??i ?????t</b>.</li>
                    <li>27/03/2022: C???p nh???t modun B??n T??i Li???u (TUT/TRICK).</li>
                    <li>25/03/2022: ON/OFF Hi???n th??? SHOP.</li> -->
                    <!-- <li>24/03/2022: Fix l???i m?? gi???m gi??.</li>
                    <li>22/03/2022: S???p x???p th??? t??? chuy??n m???c b??n t??i kho???n.</li>
                    <li>21/03/2022: Tu??? ch???nh hi???n th??? s???n ph???m tr?????c v?? sau khi ????ng nh???p.</li>
                    <li>16/03/2022: Th??nh vi??n s??? ghi nh??? phi??n ????ng nh???p, c??n Admin s??? ph???i c???n ????ng nh???p nhi???u l???n ????? t??ng t??nh b???o m???t.</li>
                    <li>15/03/2022: Ch???n ????ng nh???p qu???n tr??? n???u Fake IP.</li>
                    <li>13/03/2022: Update hi???n th??? danh s??ch acc ???? b??n.</li>
                    <li>13/03/2022: T??ng ????? d??i s???n ph???m l??n 1.000 k?? t??? thay v?? 255 nh?? m???c ?????nh.</li>
                    <li>13/03/2022: Fix API importAccount, xo?? l??u ????ng nh???p b???ng cookie.</li>
                    <li>11/03/2022: Update n???i dung n???p ti???n, kh??ng ph??n bi???t ch??? hoa hay th?????ng.</li>
                    <li>10/03/2022: Fix n???p th??? c??o.</li> 
                    <li>25/02/2022: Fix n???p th???, th??m hi???n th??? task cron job ????? debug l???i.</li>
                    <li>25/02/2022: Update ch???c n??ng b??i vi???t, t???i ??u chi ti???t 1 v??i th???.</li>
                    <li>24/02/2022: Fix hi???n th??? ho?? ????n, ??i???u ch???nh th??? t??? hi???n th??? s???n ph???m.</li>
                    <li>11/02/2022: Hi???n th??? giao d???ch g???n ????y.</li>
                    <li>10/02/2022: Th??m ph????ng t???c thanh to??n crypto th??? c??ng, t???i ??u t???c ????? load.</li>
                    <li>13/01/2022: Th??m ph????ng th???c thanh to??n qua Perfect Money</li>
                    <li>12/01/2022: Th??m t??nh n??ng v??ng quay may m???n.</li>
                    <li>09/01/2022: Tu??? ch???nh hi???u ???ng nh???p chu???t, g???i email ?????n t???ng user.</li>
                    <li>07/01/2022: G???i Email th??ng tin ????n h??ng sau khi mua h??ng, ch???nh th???i gian h???t h???n ho?? ????n theo
                        ??.</li>
                    <li>06/01/2022: Update n???p ti???n qua Paypal t??? ?????ng.</li>
                    <li>05/01/2022: Cho ph??p d??ng th??? HTML v??o ti??u ????? v?? m?? t??? s???n ph???m.</li>
                    <li>04/01/2022: Th??m ti???n t??? USD v?? tu??? ch???nh rate theo ??.</li>
                    <li>03/01/2022: Th??m th???i gian check live v?? tu??? ch???nh th???i gian check.</li>
                    <li>02/01/2022: Tu??? ch???n min n???p, fix hi???n th??? s???n ph???m, fix 1 s??? l???i nh???.</li>
                    <li>30/12/2021: Th??m n???p ti???n t??? ?????ng qua Zalo Pay.</li>
                    <li>29/12/2021: Th??m tu??? ch???n ON/OFF hi???n th??? ???? b??n, chi???t kh???u gi???m gi?? t???ng th??nh vi??n.</li> -->
                </ul>
                <i>H??? th???ng t??? ?????ng c???p nh???t phi??n b???n m???i nh???t khi v??o trang Qu???n Tr???.</i>
            </div>
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `fake` = 0 ")['COUNT(id)']);?></h3>
                            <p>????n h??ng ???? b??n</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem th??m <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL ")['COUNT(id)']);?>
                            </h3>
                            <p>T??i kho???n ???? b??n</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem th??m <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` ")['COUNT(id)']);?></h3>
                            <p>T???ng th??nh vi??n</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?=base_url_admin('users');?>" class="small-box-footer">Xem th??m <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 ")['SUM(`pay`)']);?>
                            </h3>
                            <p>Doanh thu ????n h??ng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem th??m <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Th???ng k?? th??ng <?=date('m', time());?></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ????N H??NG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">T??I KHO???N ???? B??N</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TH??NH VI??N M???I</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Th???ng k?? tu???n</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ????N H??NG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">T??I KHO???N ???? B??N</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TH??NH VI??N M???I</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Th???ng k?? h??m nay</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ????N H??NG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">T??I KHO???N ???? B??N</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TH??NH VI??N M???I</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">T???ng ti???n n???p to??n th???i gian</span>
                            <span class="info-box-number"><?=format_currency(
    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` ")['SUM(`price`)']+
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` ")['SUM(amount)']+
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' ")['SUM(price)']
);?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">T???ng ti???n n???p th??ng <?=date('m', time());?></span>
                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`pay`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE  YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`price`)']
                                +
                                $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(amount)'] 
                                +
                                $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND YEAR(created_at) = ".date('Y')." AND MONTH(created_at) = ".date('m')." ")['SUM(price)']
                                
                                );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">T???ng ti???n n???p tu???n</span>
                            <span class="info-box-number"><?=format_currency(
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(amount)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND WEEK(created_at, 1) = WEEK(CURDATE(), 1) ")['SUM(price)']
                                );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">T???ng ti???n n???p h??m nay</span>
                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(amount)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND `created_at` >= DATE(NOW()) AND `created_at` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(price)']
                                    );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                200 GIAO D???CH G???N ????Y (<i>???n d??ng ti???n c???a Admin</i>)
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
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th>S??? ti???n tr?????c</th>
                                            <th>S??? ti???n thay ?????i</th>
                                            <th>S??? ti???n hi???n t???i</th>
                                            <th>Th???i gian</th>
                                            <th>N???i dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                        <tr>
                                            <td class="text-center"><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                            </td>
                                            <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                            <td><i><?=$row['noidung'];?></i></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                <a type="button" href="<?=base_url_admin('dong-tien');?>" class="btn btn-primary">Xem
                                    Th??m <i
                                class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                200 NH???T K?? HO???T ?????NG G???N ????Y (<i>???n nh???t k?? c???a Admin</i>)
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
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th width="40%">Action</th>
                                            <th>Time</th>
                                            <th>Ip</th>
                                            <th width="30%">Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td><?=$row['action'];?></td>
                                            <td><?=$row['createdate'];?></td>
                                            <td><?=$row['ip'];?></td>
                                            <td><?=$row['device'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                <a type="button" href="<?=base_url_admin('logs');?>" class="btn btn-primary">Xem
                                    Th??m <i
                                class="fas fa-arrow-circle-right"></i></a>
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
 