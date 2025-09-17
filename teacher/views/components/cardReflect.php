<?php

// กำหนดข้อความและปุ่มตามสถานะ
switch ($data['status']) {
    case 'waiting':
        $statusText = 'เปิดให้ทำแบบสะท้อน';
        $action = '<button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 cursor-pointer">บันทึก</button>';
        $disabled = '';
        break;
        case 'reviewed':
        $statusText = 'อ่านข้อมูลสะท้อน';
        $action = '';
        $disabled = 'disabled';
        break;
        case 'upcoming':
        $statusText = 'ยังไม่เปิดให้สะท้อน';
        $action = '';
        $disabled = 'disabled';
        break;
        default:
        $statusText = '';
        $action = '';
        $disabled = 'disabled';
    }

    // ตัวอย่างการ์ด workshop
    ?>
    <div class="w-full lg:w-1/3 min-h-[30rem] rounded-lg shadow bg-white p-4 flex flex-col border-2 <?= ($data['status'] === 'waiting' ? 'border-purple-500' : 'border-gray-300') ?>">


            <h3 class="font-bold text-xl text-center mb-2">Workshop <?= htmlspecialchars($data['id']) ?></h3>
            <h3 class="font-semibold text-lg mb-2">สะท้อนคิด</h3>
        <?php if ( $isActive = ($data['status'] === 'waiting')): ?>
            <textarea disabled class="min-h-[10rem] border-2 border-gray-100 p-2 text-gray-600 mb-3 overflow-auto resize-none"><?= htmlspecialchars($data['reflect']) ?></textarea>
             <h3 class="font-semibold text-lg mb-2">คำแนะนำจากที่ปรึกษา <span class="text-red-500">*</span></h3>
                    <textarea class="min-h-[3rem] border-2 border-purple-300 p-2 text-gray-600 mb-3 overflow-auto resize-none">d</textarea>

           <div id="score" class="w-full flex items-center gap-4 justify-center p-4">
                        ใส่คะแนน :
                        <div class="text-xl border border-purple-500 shadow-md w-fit py-4 px-12 rounded-lg flex">
                            <span class="text-center pr-2">
                               
                                        <input type="text" name="" id="" class="w-8 text-green-500 border-b-1 border-b-green-500 text-center outline-none">
        
                            </span>
                            <span class="text-center">/ 10</span>
                        </div>
                    </div>
        <?php endif; ?>
            
        <?php if ( $isActive = ($data['status'] === 'reviewed')): ?>
            <div class="h-[10rem] border-2 border-gray-100 p-2 text-gray-600 mb-3 overflow-auto"><?= htmlspecialchars($data['reflect']) ?></div>
            <div>
                <h3 class="font-semibold text-lg mb-2">คำแนะนำจากที่ปรึกษา</h3>
                <div class="h-[10rem] border-2 border-gray-100 p-2 text-gray-600 mb-3 overflow-auto">
                    <?php if (!empty($data['advisor'])): ?>
                        <?php foreach ($data['advisor'] as $advisor): ?>
                            <p class="font-bold"><?= htmlspecialchars($advisor['name']) ?> (คะแนน: <?= htmlspecialchars($advisor['score']) ?>)</p>
                            <p class="mb-2"><?= htmlspecialchars($advisor['comments']) ?></p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-400">ไม่มีคำแนะนำจากที่ปรึกษา</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-400 text-sm"><?= ($data['status'] === 'upcoming' ? 'ยังไม่เปิดให้ทำกิจกรรม' : '') ?></p>
        <?php endif; ?>
        


        <?= $action ?>
       
    </div>
