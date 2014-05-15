document.write("\
                <div id=\"main_header\">\
                    <div id=\"container_upper\">\
                        <div id=\"left_box_logo\">\
                            <img id=\"logo\" src=\"img/logo.png\" alt=\"CR_IL_logo\" width=\"90\" height=\"45\">\
                        </div>\
                        <div id=\"right_box_text\">\
                            <div id=\"company_he\" dir=\"rtl\"> אגודת ידידות קוסטה-ריקה ישראל </div>\
                            <div id=\"company_en\" dir=\"rtl\"> Costa-Rica Israel Friendship Association </div>\
                        </div>\
                    </div>\
                    <nav>\
                        <ul>\
                            <li>\
                                <a href=\"index.html\" > Home</a>\
                            </li>\
                            <li>\
                                <a href=\"about.html\" > About us</a>\
                            </li>\
                            <li>\
                                <a href=\"events.html\" > Events</a>\
                            </li>\
                            <li>\
                                <a href=\"subscribe.html\" > Subscribe</a>\
                            </li>\
                            <li>\
                                <a href=\"contest.php\" > Know Costa Rica Contest</a>\
                            </li>\
                            <li>\
                                <a href=\"contact.html\" > Contact Us</a>\
                            </li>\
                            <li id=\"language\">\
                                <a href=\"#\" onclick=\"document.body.className='en'\"> English </a> /\
                                <a href=\"#\" onclick=\"document.body.className='sp'\">Español</a>\
                            </li>\
                            <li id=\"hello_user\">\
                                Hello {{user}}\
                            </li>\
                        </ul>\
                    </nav>\
                </div>\
");
