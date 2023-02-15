 <!-- Start Footer -->
 <footer id="footer">

     <div class="footer-top">
         <div class="container">
             <div class="row">

                 <div class="col-lg-6  col-md-3 footer-contact">
                     <strong>Address:</strong><br>
                     <p>
                     <p>{{ _address() }}</p><br>
                     <strong>Phone:</strong><br> <a href="tel:+919913740441">{{ _settings('CONTACT_NUMBER') }}</a><br>
                     <a href="tel:+919712731131">{{ _settings('ALTERNATE_CONTACT_NUMBER') }}</a><br>
                     <a href="tel:+919825356656">{{ _settings('MAIN_CONTACT_NUMBER') }}</a><br><br>
                     <strong>Email:</strong><br> {{ _settings('CONTACT_EMAIL') }}<br>
                     
                     </p>
                 </div>

                 <div class="col-lg-6 text-right col-md-3 footer-links">
                     <h4>Useful Links</h4>
                     <ul>
                         <li><i class="bx bx-chevron-right"></i> <a href="{{ route('home') }}">Home</a></li>
                         <li><i class="bx bx-chevron-right"></i> <a href="{{ route('about') }}">About us</a></li>
                         <li><i class="bx bx-chevron-right"></i> <a href="{{ route('product') }}">Products</a></li>
                         <li class="d-none"><i class="bx bx-chevron-right"></i> <a href="{{ route('client') }}">Clients</a></li>
                         <li><i class="bx bx-chevron-right"></i> <a href="{{ route('contact') }}">Contact</a></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>

     <div class="container d-md-flex py-4">

         <div class="me-md-auto text-center text-md-start">
             <div class="copyright">
                 &copy; Copyright <strong><span>Taj Sales</span></strong>. All Rights Reserved
             </div>
             <div class="credits">
                 <!-- All the links in the footer should remain intact. -->
                 <!-- You can delete the links only if you purchased the pro version. -->
                 <!-- Licensing information: https://bootstrapmade.com/license/ -->
                 <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flattern-multipurpose-bootstrap-template/ -->
             </div>
         </div>

     </div>
 </footer><!-- End Footer -->
 <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>