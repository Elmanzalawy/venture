<footer id="main-footer">
    <div class="container">
        <div class="row">
            <div class="col md-6">
                <h6>Social Media</h6>
                    <a href="#" target="_blank"><span class="fa fa-facebook"></span> </a>
                    <a href="#" target="_blank"><span class="fa fa-twitter"></span> </a>
                    <a href="#" target="_blank"><span class="fa fa-youtube"></span> </a>
            </div>

            <div class="col md-6">
                <h6>Misc.</h6>
                <ul id="contact-us" class="list-unstyled">
                    @if(!Auth::guest())
                    <li>
                        <a href="#" id="contact-family" data-toggle="modal" data-target="#contact-us-modal">Contact Us</a>
                    </li>
                    @endif
                    <li><i>
                        &copy; <?php echo idate('Y'); ?>
                    </i></li>
                    @if(!Auth::guest())
                    <li>
                        <i> Designed by
                            <a href="#" id="contact-designer" data-toggle="modal" data-target="#contact-designer-modal">M. Elmanzalawy</a>
                        </i>
                        <br>
                        </i>
                    </li>
                    @else
                    <li><i>Designed by M. Elmanzalawy</i></li>
                    @endif
                </ul>

            </div>

        </div>
    </div>
</footer>

@if(!Auth::guest())
<!--CONTACT DESIGNER MODAL-->
<div class="modal fade" id="contact-designer-modal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Contact M. Elmanzalawy</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post"  enctype="multipart/form-data" action="
              <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- message body -->
                <div class="form-group">
                  <label for="message-body" class="col-form-label">Message</label>
                  <textarea rows="10" class="form-control" id="contact-message" name="message-body" placeholder="Message Mohamed Elmanzalawy..."></textarea>
                </div>
                 <!-- submit form -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <input type="submit" name="contact-designer" value="Send" class="btn btn-primary">
                </div>
              </form>
            </div>
     
          </div>
        </div>
      </div>
     <!--END MODAL-->

     <!--CONTACT US MODAL-->
 <div class="modal fade" id="contact-us-modal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post"  enctype="multipart/form-data" action="
              <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- message body -->
                <div class="form-group">
                  <label for="message-body" class="col-form-label">Message</label>
                  <textarea rows="10" class="form-control" id="contact-message" name="message-body" placeholder="Send us your feedback."></textarea>
                </div>
                 <!-- submit form -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <input type="submit" name="contact-us" value="Send" class="btn btn-primary">
                </div>
              </form>
            </div>
     
          </div>
        </div>
      </div>
     <!--END MODAL-->
@endif