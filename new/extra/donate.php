<div class="extra">
        <div id="donate">Infinity-forum is free for non-profit users and we have chose not to have adds and annoying popups that will molest your <br/>
        mind for all eternity or make you missclick on an add and acidently close wrong tab <br/>
        so your work is lost or your music stops or even worse... <br />
        WHAT HAPPENS IF YOU ACIDENTLY CLOSE DOWN YOUR PRESSIOUS FACEBOOK :S <br/>
        to avode us getting adds to run we rely on your donations<br />
        <div id="slider-result">15$</div>  
        <div class="Dslider"></div>
        <input type="hidden" id="hidden"/>
        <div id="donate_btn">Donate</div>
        
        </div>
        <div id="feedback">
            <form action="/feedback/send" method="post" id="send_feedback">
            <div id="feed_box">
                <div id="feed_box_1">
                    <table id="feed_box_1_tbl">
                        <tr>
                            <th>Leave feedback 1/4<hr /></th>
                        </tr>
                        <tr>
                            <td>Please leave feedback here to help us make this site better; you can choose to be anonymous.<br/>
        We look over the feedback to know how we can improve the site and get what users want.</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <?php
                            if ($logged)
                            {
                                echo '<tr><td>Do you want to be anonymous when leaving feedback?</td></tr>';
                                echo '<tr><td><input type="checkbox" name="anon" id="fee_anon" /> Check for Yes</td></tr>';    
                            }
                        ?>
                        
                    </table>
                    <div class="btn" id="feed_next_1">Next</div>
                </div>
                
                
                <div id="feed_box_2">
                    <table id="feed_box_2_tbl">
                        <tr>
                            <th colspan="13">Leave feedback 2/4<hr /></th>
                        </tr>
                        <tr>
                            <td colspan="13">What is your overall impression of the layout?</td>
                        </tr>   
                        <tr>
                            <td align="right">Terrible</td>
                            <td width="35px" align="right"><input type="radio" name="fee_l" value="0" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="1" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="2" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="3" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="4" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="5" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="6" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="7" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="8" class="fee_l" /></td>
                            <td><input type="radio" name="fee_l" value="9" class="fee_l" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_l" value="10" class="fee_l" /></td> 
                            <td align="left">AWESOME!!!</td>
                        </tr>                     
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan="13">How easy is it to navigate the site?</td>
                        </tr>
                        <tr>
                            <td align="right">Extremely easy</td>
                            <td width="35px" align="right"><input type="radio" name="fee_n" value="0" class="fee_l" /></td>
                            <td><input type="radio" name="fee_n" value="1" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="2" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="3" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="4" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="5" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="6" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="7" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="8" class="fee_n" /></td>
                            <td><input type="radio" name="fee_n" value="9" class="fee_n" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_n" value="10" class="fee_n" /></td>
                            <td align="left">How do I get out of here?</td>
                        </tr>
                    </table>
                    <div class="btn" id="feed_next_2">Next</div>
                </div>
            
            
            <div id="feed_box_3">
                    <table id="feed_box_3_tbl">
                        <tr>
                            <th colspan="13">Leave feedback 3/4<hr /></th>
                        </tr>
                        <tr>
                            <td colspan="13">What is your overall impression of the functionality?</td>
                        </tr>
                        <tr>
                            <td align="right">You call that functionality? </td>
                            <td width="35px" align="right"><input type="radio" name="fee_f" value="0" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="1" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="2" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="3" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="4" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="5" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="6" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="7" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="8" class="fee_f" /></td>
                            <td><input type="radio" name="fee_f" value="9" class="fee_f" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_f" value="10" class="fee_f" /></td>
                            <td align="left">Excellent!</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan="13">How easy was it to understand what the site is about?</td>
                        </tr>
                        <tr>
                            <td align="right">I still have no clue. </td>
                            <td width="35px" align="right"><input type="radio" name="fee_a" value="0" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="1" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="2" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="3" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="4" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="5" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="6" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="7" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="8" class="fee_a" /></td>
                            <td><input type="radio" name="fee_a" value="9" class="fee_a" /></td>
                            <td width="35px" align="left"><input type="radio" name="fee_a" value="10" class="fee_a" /></td>
                            <td align="left">I knew it before I came here!</td>
                        </tr>
                    </table>
                    <div class="btn" id="feed_next_3">Next</div>
                </div>
            
            
                   <div id="feed_box_4">
                    <table id="feed_box_4_tbl">
                        <tr>
                            <th colspan="13">Leave feedback 4/4</th>
                        </tr>
                        <tr>
                            <td colspan="13">Leave comments or suggestions here.</td>
                        </tr>
                    </table>
                    <textarea id="feed_com" name="comments"></textarea>
                    <div class="btn" id="feed_next_4">Send</div>
                </div>
            </div>
            <div id="fee_err">Something went wrong; please check that you have marked all questions.</div>
            </form>
        </div>
    </div>