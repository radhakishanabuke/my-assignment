<?php
echo "Hi, ".$this->session->userdata('user_name');
echo "<a href='logout'>Logout</a>";