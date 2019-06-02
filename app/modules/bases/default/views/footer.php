<div id="footer-wrapper" class="footer bg">
    <div class="footer-overlay overlay"></div>

    <footer class="">
        <div style="color: white;background-color: black">
            <div class="text-center" style="text-align: left; padding: 10px">
                &copy; CrystalPHP, Crystal Collective.
            </div>
        </div>
    </footer>
</div>
<?php
\CrystalPHP\Document::addStyle("
    #footer-wrapper{
        clear: both;
        position: absolute;
        bottom:0;
        width: 100vw;
        height:50px;
   
    }");