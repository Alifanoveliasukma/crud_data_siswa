<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = [ 'user_id','nama_depan', 'nama_belakang', 'jenis_kelamin', 'agama', 'alamat', 'avatar'];

    public function getAvatar()
    {
        if (!$this->avatar) {
            return asset('images/df.png');
        }
        return asset('images/' . $this->avatar);
    }
    public function mapel()
    {
        return $this->belongsTomany(Mapel::class)->withPivot(['nilai'])->withTimestamps();
    }
}
