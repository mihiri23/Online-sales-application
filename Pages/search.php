
                <div class="header_search">
                    <div class="header_search_content">
                        <div class="header_search_form_container">
                            <form action="../Pages/searchitems.php" class="header_search_form clearfix">
                                <input type="search" required="required" class="header_search_input" placeholder="Search for Items...">
                                <div class="custom_dropdown">
                                    <div class="custom_dropdown_list">
                                        <span class="custom_dropdown_placeholder clc">All Categories</span>
                                        <i class="fas fa-chevron-down"></i>
                                        <ul class="custom_list clc">
                                            <li><a class="clc" href="../Pages/searchitems.php?cat_id=0">All Categories</a></li>
                                            <?php while ($row = $rcat->fetch(PDO::FETCH_BOTH)) { ?>
                                                <li><a class="clc" href="../Pages/searchitems.php?cat_id=<?php echo $row['cat_id']; ?>"><?PHP echo $row['cat_name']; ?></a></li>
                                            <?PHP } ?>
                                        </ul>
                                    </div>
                                </div>
                                <button type="submit" class="header_search_button trans_300" value="Submit"><img src="images/search.png" alt=""></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
