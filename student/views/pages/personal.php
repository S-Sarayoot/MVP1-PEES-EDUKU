<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
  <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
  
  <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- First Name -->
    <div>
      <label class="text-sm text-gray-600">First Name & Middle Name</label>
      <input type="text" placeholder="Enter your first name"
        class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
    </div>

    <!-- Last Name -->
    <div>
      <label class="text-sm text-gray-600">Last Name</label>
      <input type="text" placeholder="Enter your last name"
        class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
    </div>

    <!-- Nationality -->
    <div>
      <label class="text-sm text-gray-600">Nationality</label>
      <select class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
        <option>Thai</option>
        <option>American</option>
        <option>Japanese</option>
      </select>
    </div>

    <!-- Passport ID -->
    <div>
      <label class="text-sm text-gray-600">Passport ID</label>
      <input type="text" placeholder="Enter your passport ID"
        class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
    </div>

    <!-- Date of Birth -->
    <div>
      <label class="text-sm text-gray-600">Date of Birth (Optional)</label>
      <input type="date"
        class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
    </div>

    <!-- Phone Number -->
    <div>
      <label class="text-sm text-gray-600">Phone Number</label>
      <div class="flex">
        <select class="border rounded-l-md px-2 focus:outline-none focus:ring focus:ring-blue-300">
          <option>+66</option>
          <option>+1</option>
          <option>+81</option>
        </select>
        <input type="text" placeholder="Enter phone number"
          class="flex-1 px-3 py-2 border-t border-b border-r rounded-r-md focus:outline-none focus:ring focus:ring-blue-300">
      </div>
    </div>

    <!-- Email (Read-only) -->
    <div class="md:col-span-2">
      <label class="text-sm text-gray-600">Email</label>
      <input type="email" value="65209010013@thonburi.ac.th" readonly
        class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 text-gray-500">
    </div>

    <!-- Save Button -->
    <div class="md:col-span-2 flex justify-end">
      <button type="submit"
        class="px-6 py-2 rounded-md bg-gradient-to-r from-green-400 to-blue-400 text-white font-semibold shadow hover:opacity-90 transition">
        Save
      </button>
    </div>
  </form>
</div>
