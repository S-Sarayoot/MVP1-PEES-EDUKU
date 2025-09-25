<div class="bg-white p-4 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mx-2mt-2">Workshop#<?= $_GET['workshop'] ?> กิจกรรม</h1>
    <div class="flex flex-col md:flex-row w-full gap-4 mt-4">
        <div class="w-full md:w-1/3 ">
            <div class="border-2 border-purple-200 p-4 rounded-lg">
                <div class="">
                   <h2 class="text-xl underline font-bold text-purple-800">คำชี้แจง</h2>
                   <p>
                       กิจกรรมนี้มีวัตถุประสงค์เพื่อให้นักเรียนได้ฝึกทักษะการอ่านและการคิดวิเคราะห์ผ่านการตอบคำถามที่เกี่ยวข้องกับบทบาทของครูในยุคเทคโนโลยีดิจิทัล
                       โดยนักเรียนจะได้เรียนรู้ถึงความสำคัญของการใช้เทคโนโลยีในการศึกษาและการพัฒนาทักษะที่จำเป็นในศตวรรษที่ 21 รวมถึงการตระหนักถึงคุณธรรมและจริยธรรมที่ครูควรมี
                       เพื่อเตรียมความพร้อมในการเป็นครูที่มีคุณภาพและสามารถตอบสนองต่อความต้องการของผู้เรียนในยุคปัจจุบันได้อย่างมีประสิทธิภาพ                
                   </p>
               </div>
   
               <div class="mt-4">
                   <h2 class="text-xl font-bold">ทรัพยากรที่เกี่ยวข้อง</h2>
                   <ul class="list-disc list-inside mt-2">
                       <li><a href="https://dev.kittelweb.xyz/student/resource.php?workshop=<?= $_GET['workshop'] ?>" class="text-purple-600 hover:underline">เทคโนโลยีกับการศึกษา [กรณีศึกษา] - นายเอ บีซีดี</a></li>
                       <li><a href="https://dev.kittelweb.xyz/student/resource.php?workshop=<?= $_GET['workshop'] ?>" class="text-purple-600 hover:underline">บทบาทของครูในยุคเทคโนโลยีดิจิทัล - นางสาวใจดี มากเลย</a></li>
                       <li><a href="https://dev.kittelweb.xyz/student/resource.php?workshop=<?= $_GET['workshop'] ?>" class="text-purple-600 hover:underline">แหล่งเรียนรู้เพิ่มเติม</a></li>
               </div>
               
               <div class="mt-4">
                   <h2 class="text-xl font-bold">Rubrics</h2>
                   <div class="grid grid-cols-5 gap-2 text-sm">
                       <div class="flex flex-col items-center text-right">
                           <span class="w-full px-1 ">1</span>
                           ความถูกต้องของคำตอบ
                       </div>
   
                       <div class="flex flex-col items-center text-right">
                           <span class="w-full px-1 ">2</span>
                           ความชัดเจนและความสมบูรณ์ของคำอธิบาย
                       </div>
   
                       <div class="flex flex-col items-center text-right">                    
                           <span class="w-full px-1 text-white  bg-purple-500">3</span>
                           การใช้ภาษาและการสื่อสารที่เหมาะสม
                       </div>
                       <div class="flex flex-col items-center text-right">
                           <span class="w-full px-1 ">4</span>    
                           การเชื่อมโยงกับเนื้อหาที่เรียน
                       </div>
                       <div class="flex flex-col items-center text-right">
                           <span class="w-full px-1 ">5</span>    
                           ความคิดสร้างสรรค์และการวิเคราะห์
                       </div>
                   </div>
               </div>
   
                <div class="mt-4">
                   <a href="https://dev.kittelweb.xyz/student/workshop/reflection" class="w-full px-4 py-2 border-2 border-purple-500 text-purple-500 font-bold hover:bg-purple-500 hover:text-white rounded-lg my-4 cursor-pointer">สะท้อนคิด</a>
               </div>
            </div>
        </div>

        <div class="w-full md:w-2/3">
           
            <div class="">
                    <div class="mb-4">
                        <span>1.อ่านและตอบคำถามดังต่อไปนี้</span>
                    </div>
                    <p class="text-sm border border-gray-200 mx-4 p-4 text-wrap">ในปัจจุบัน การศึกษาไม่ได้มุ่งเน้นเพียงการสอนความรู้ในตำราเท่านั้น 
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
                            <textarea disabled id="message" class="mt-2 field-sizing-fixed w-full caret-purple-500 outline-none border border-purple-500 rounded-lg p-4">ครูมีบทบาทเป็นผู้อำนวยความสะดวกในการเรียนรู้ (facilitator) โดยใช้เทคโนโลยีช่วยเสริมสร้างประสบการณ์การเรียนรู้ให้กับนักเรียน</textarea>
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
                        
                    </form>
                    <div id="score" class="w-full flex items-center gap-4 justify-center p-4">
                        ใส่คะแนน :
                        <div class="text-xl border border-purple-500 shadow-md w-fit py-4 px-12 rounded-lg flex">
                            <span class="text-center pr-2">
                                (
                                    5 + 
                                    <span>
                                        <input type="text" name="" id="" class="w-8 text-green-500 border-b-1 border-b-green-500 text-center outline-none">
                                    </span> 
                                )
                            </span>
                            <span class="text-center">/ 10</span>
                        </div>
                        <button  class="px-4 py-2 bg-purple-500 text-white rounded-lg my-4 cursor-pointer">บันทึกคะแนน</button>
                    </div>
            </div>
        </div>

        
    </div>
</div>