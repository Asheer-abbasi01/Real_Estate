    <!-- ======= Latest Properties Section ======= -->
    <section class="section-property section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Latest Properties</h2>
              </div>
              <div class="title-link">
                <a href="property-grid.php">All Property
                  <span class="bi bi-chevron-right"></span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div id="property-carousel" class="swiper">
          <div class="swiper-wrapper">

          <?php
                 $conn = mysqli_connect("localhost", "root","","demo") or die("Connection failed....");
                 $sql = "SELECT * FROM properties";
                 $result = mysqli_query($conn, $sql);
                 while ($row = mysqli_fetch_assoc($result)) {
            ?>

            <div class="carousel-item-b swiper-slide">
              <div class="card-box-a card-shadow">
                <div class="img-box-a">
                  <img src="assets/img/<?php echo $row['image']; ?>" alt="" class="img-a img-fluid">
                 </div>
                <div class="card-overlay">
                  <div class="card-overlay-a-content">
                    <div class="card-header-a">
                      <h2 class="card-title-a">
                        <a > <?php echo $row['propertyName']; ?></a>
                      </h2>
                    </div>
                    <div class="card-body-a">
                      <div class="price-box d-flex">
                        <span class="price-a">rent | pkr <?php echo $row['price']; ?></span>
                      </div>
                      <a href="#" class="link-a">Click here to view
                        <span class="bi bi-chevron-right"></span>
                      </a>
                    </div>
                    <div class="card-footer-a">
                      <ul class="card-info d-flex justify-content-around">
                        <li>
                          <h4 class="card-info-title">Area</h4>
                          <span><?php echo $row['area']; ?>
                            <sup>2</sup>
                          </span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Beds</h4>
                          <span><?php echo $row['beds']; ?></span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Baths</h4>
                          <span><?php echo $row['baths']; ?></span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Garages</h4>
                          <span><?php echo $row['garages']; ?></span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End carousel item -->

            
          </div>
        </div>
        <?php
         }
     ?>
        <div class="propery-carousel-pagination carousel-pagination"></div>

      </div>
    </section>