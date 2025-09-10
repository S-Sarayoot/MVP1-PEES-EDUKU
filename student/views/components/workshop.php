<?php
$categories = $categories ?? ['ทั้งหมด'];
$active = $active ?? 'ทั้งหมด';
$items = $items ?? [];
?>


<div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-lg sm:text-xl text-[#433878] mb-4 md:mx-4">Workshop กิจกรรม</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Workshop กิจกรรม</p>
            </div>
            <div
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                <h1 class="text-xl font-semibold mx-2 text-[#433878] text-center mt-2"> กิจกรรม</h1>
                <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200 my-4 mx-2">
                    <span class="font-semibold underline mx-4 text-purple-800">คำชี้แจง</span>
                    <span>คำชี้แจงกิจกรรม</span>
                </div>
                <div class="mx-4 mt-6">
                        <div class="mb-4">
                            <span>1.อ่านและตอบคำถามดังต่อไปนี้</span>
                        </div>
                        <p class="text-sm border border-gray-200 mx-4 p-4 text-wrap">
                            ในปัจจุบัน การศึกษาไม่ได้มุ่งเน้นเพียงการสอนความรู้ในตำราเท่านั้น 
                            แต่ยังให้ความสำคัญกับการพัฒนาทักษะที่จำเป็นต่อการดำรงชีวิตในศตวรรษที่ 21 เช่น 
                            การคิดวิเคราะห์ การทำงานร่วมกับผู้อื่น การแก้ปัญหา และการใช้เทคโนโลยีอย่างสร้างสรรค์
                            ครูจึงไม่ใช่เพียงผู้ถ่ายทอดความรู้ แต่ยังเป็นผู้อำนวยความสะดวก (facilitator) ผู้สร้างแรงบันดาลใจ 
                            และผู้ส่งเสริมให้นักเรียนสามารถเรียนรู้ด้วยตนเองได้อย่างต่อเนื่อง
                            ครูที่ดีต้องมีความสามารถในการปรับวิธีการสอนให้เหมาะกับผู้เรียนที่มีความแตกต่างกัน 
                            และใช้สื่อหรือเทคโนโลยีช่วยเพิ่มประสิทธิภาพในการเรียนรู้
                            นอกจากนี้ ครูยังต้องมีคุณธรรม จริยธรรม และความรับผิดชอบต่อสังคม เพราะครูถือเป็นต้นแบบที่นักเรียนมักยึดถือ 
                            การเป็นครูที่มีทั้งความรู้ ความสามารถ และความเมตตา จึงเป็นสิ่งสำคัญที่จะช่วยพัฒนาผู้เรียนให้เป็นพลเมืองที่มีคุณภาพ
                        </p>
                        <form onsubmit="checkAnswer(event)">
                            <div class="mx-4 my-4">
                                <label for="message" class="text-sm">1.1 บทบาทใดของครูที่เกี่ยวข้องกับการใช้เทคโนโลยี?</label>
                                <textarea id="message" class="mt-2 field-sizing-fixed w-full caret-purple-500 outline-none border border-purple-500 rounded-lg p-4"></textarea>
                            </div>
                            <div class="mb-4 flex flex-col space-y-3">
                                <p>2.ทำไมครูควรมีคุณธรรมและจริยธรรม?</p>
                                <div class="flex text-sm mx-3">
                                    <input id="choice-1" type="radio" name="q2" value="a">
                                    <label for="choice-1" class="ml-3">เพื่อเป็นต้นแบบที่ดีแก่นักเรียน</label>
                                </div>
                                 <div class="flex text-sm mx-3">
                                    <input id="choice-2" type="radio" name="q2" value="b">
                                    <label for="choice-2" class="ml-3">เพื่อได้รับเงินเดือนสูงขึ้น</label>
                                </div>
                                 <div class="flex text-sm mx-3">
                                    <input id="choice-3" type="radio" name="q2" value="c">
                                    <label for="choice-3" class="ml-3">เพื่อสอนเนื้อหาได้ถูกต้อง</label>
                                </div>
                                 <div class="flex text-sm mx-3">
                                    <input id="choice-4" type="radio" name="q2" value="d">
                                    <label for="choice-4" class="ml-3">เพื่อทำงานแทนผู้ปกครอง</label>
                                </div>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-purple-500 text-white rounded-lg my-4">ส่งคำตอบ</button>
                        </form>
                        <div id="score" class="w-full flex justify-center p-4">

                        </div>
                </div>
            </div>
        </div>