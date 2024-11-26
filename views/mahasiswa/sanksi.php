<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <?php
        include("header.php");
        ?>

        <!-- Sidebar -->
        <?php
        include("sidebar.php");
        ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Peraturan</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Sanksi</a></li>
                    </ol>
                </div>
                <!-- Section: Sanksi Pelanggaran -->
                <div class="card border mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0 text-dark">Akumulasi Sanksi Pelanggaran</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-dark">
                            Perbuatan/tindakan pelanggaran Tata Tertib Kehidupan Kampus akan
                            diakumulasikan untuk setiap kategori pelanggaran dan berlaku sepanjang mahasiswa
                            masih tercatat sebagai mahasiswa di Polinema.
                        </p>
                        <ul class="list-unstyled text-dark">
                            <li>a. Apabila pelanggaran tingkat V dilakukan 3 (tiga) kali maka klasifikasi
                                pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat IV.</li>
                            <li>b. Apabila pelanggaran tingkat IV dilakukan 3 (tiga) kali maka klasifikasi
                                pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat III.</li>
                            <li>c. Apabila pelanggaran tingkat III dilakukan 3 (tiga) kali maka klasifikasi
                                pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat II.</li>
                            <li>d. Apabila pelanggaran tingkat II dilakukan 3 (tiga) kali maka klasifikasi
                                pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat I.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section: Sanksi Berdasarkan Tingkat Pelanggaran -->
                <div class="card border mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0 text-dark">Sanksi Pelanggaran</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-dark">Berikut adalah sanksi yang diberikan berdasarkan tingkat pelanggarannya:</p>
                        <ol class="text-dark">
                            <li><strong>1. Sanksi atas pelanggaran Tingkat V</strong> yang dilakukan oleh mahasiswa berupa:
                                <ul>
                                    <li> Teguran lisan disertai dengan surat pernyataan tidak mengulangi perbuatan tersebut,
                                        dibubuhi materai, ditandatangani mahasiswa yang bersangkutan dan DPA;</li>
                                </ul>
                            </li>
                            <li><strong>2. Sanksi atas pelanggaran Tingkat IV</strong> yang dilakukan oleh mahasiswa berupa:
                                <ul>
                                    <li> Teguran tertulis disertai dengan pemanggilan orang tua/wali dan membuat surat
                                        pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai, ditandatangani
                                        mahasiswa, orang tua/wali, dan DPA;</li>
                                </ul>
                            </li>
                            <li><strong>3.Sanksi atas pelanggaran Tingkat III</strong> yang dilakukan oleh mahasiswa berupa:
                                <ul>
                                    <li> a. Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai
                                        ditandatangani mahasiswa, orang tua/wali, dan DPA;</li>
                                    <li> b. Melakukan tugas khusus, misalnya bertanggungjawab untuk memperbaiki atau membersihkan kembali,
                                        dan tugas-tugas lainnya.</li>
                                </ul>
                            </li>
                            <li><strong>4. Sanksi atas pelanggaran Tingkat II</strong> yang dilakukan oleh mahasiswa berupa:
                                <ul>
                                    <li> a. Dikenakan penggantian kerugian atau penggantian benda/barang semacamnya dan/atau;</li>
                                    <li> b .Melakukan tugas layanan sosial dalam jangka waktu tertentu dan/atau;</li>
                                    <li> c .Diberikan nilai D pada mata kuliah terkait saat melakukan pelanggaran.</li>
                                </ul>
                            </li>
                            <li><strong>5. Sanksi atas pelanggaran Tingkat I</strong> yang dilakukan oleh mahasiswa berupa:
                                <ul>
                                    <li> a. Dinonaktifkan (Cuti Akademik/ Terminal) selama dua semester dan/atau;</li>
                                    <li> b. Diberhentikan sebagai mahasiswa.</li>
                                </ul>
                            </li>
                            <li><strong>6. Pemberian sanksi dan mekanisme</strong> ditetapkan dalam peraturan tersendiri.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!--**********************************
            Content body end
			***********************************-->






            <!--**********************************
           Support ticket button start
        ***********************************-->

            <!--**********************************
           Support ticket button end
        ***********************************-->


        </div>
        <!--**********************************
        Main wrapper end
    ***********************************-->
        <!--**********************************
            Footer start
        ***********************************-->
        <?php
        include("footer.php");
        ?>
        <!--**********************************
            Footer end
        ***********************************-->
</body>

</html>