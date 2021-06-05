    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= count($peserta); ?></h3>

                                <p>Total Peserta</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= count($lunas); ?></h3>

                                <p>Lunas Pembayaran</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
            <?php
            $inputs = session()->getFlashdata('inputs');
            $errors = session()->getFlashdata('errors');
            $error = session()->getFlashdata('error');
            $success = session()->getFlashdata('success');
            if(!empty($errors)){ ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                <?php foreach ($errors as $errors) : ?>
                    <li><?= esc($errors) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
            <br />
            <?php
            } 
            if(!empty($error)){ ?>
            <div class="alert alert-danger" role="alert">
                <?= esc($error) ?><br />
            </div>
            <br />
            <?php } 
            if(!empty($success)){?>
            <div class="alert alert-success" role="alert">
                <?= esc($success) ?><br />
            </div>
            <br />
            <?php } ?>
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Daftar Peserta</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="myTable"> 
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Instansi</th>
                                            <th>Kategori</th>
                                            <th>Email</th>
                                            <th>No. HP</th>
                                            <th>HTM</th>
                                            <th>Tanggal Daftar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach($peserta as $row){?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['instansi']; ?></td>
                                            <td><?= $row['category']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['hp']; ?></td>
                                            <td>
                                                <?php if($row['htm'] == 0){
                                                    echo '<span class="badge badge-danger"><a style="color: white" href="'.base_url("admin/changeHTM/".$row['id']).'">Belum Bayar</a></span>';
                                                } else {
                                                    echo '<span class="badge badge-success"><a style="color: white" href="'.base_url("admin/changeHTM/".$row['id']).'">Sudah Bayar</a></span>';
                                                } ?>
                                            </td>
                                            <td><?= $row['tanggal_daftar']; ?></td>
                                        </tr>
                                        <?php 
                                        $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->