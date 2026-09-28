use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webinar_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID User yang mendaftar
            $table->foreignId('webinar_id')->constrained()->onDelete('cascade'); // ID Webinar yang dipilih
            $table->string('payment_method')->nullable(); // Menyimpan pilihan metode bayar (dana, ovo, gopay, bank)
            $table->string('payment_proof')->nullable(); // Untuk menyimpan foto bukti bayar (kosong jika gratis)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 
            // 'pending' = Menunggu verifikasi (untuk berbayar)
            // 'approved' = Langsung sukses/disetujui (untuk gratis atau setelah diverifikasi organizer)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webinar_registrations');
    }
};