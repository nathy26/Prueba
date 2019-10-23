namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Input;

/**
 * Description of TransaccionController
 *
 * @author nathy
 */
class TransaccionController extends Controller{
    
    public function listart($external) {
        
        $cuenta = \App\Models\Cuenta::where('external_id', $external)->first();
        $cuenta = \App\Models\Cuenta::find($cuenta->id);
            
        $dato['listatc'] = \App\Models\Transaccion::all();
        return view("fragmentos.cuenta.cuenta", $datos);
    }
}
