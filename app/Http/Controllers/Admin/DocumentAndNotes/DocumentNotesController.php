<?php

namespace App\Http\Controllers\Admin\DocumentAndNotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentNotesController extends Controller
{
    public function getNotes(Request $request)
    {
        $search = '';
        if($request->has('from_date') && $request->has('to_date')){
            $search = " where date(add_date) >= '".$request->from_date."' and date(add_date) <= '".$request->to_date."';";
        }
        $sql = "select * from
                (
                              select 'drivers'   as type, notes_driver.id,    note_type, content, notes_driver.add_date, attached, admins.name as admin_name, driver.name as owner from notes_driver   left join admins on notes_driver.admin_id = admins.id       left join driver on driver.id = notes_driver.driver_id
                    union all select 'vechiles'  as type, notes_vechile.id,   note_type, content, notes_vechile.add_date, attached, admins.name as admin_name, vechile.plate_number as owner from notes_vechile left join admins on notes_vechile.admin_id = admins.id      left join vechile on vechile.id = notes_vechile.vechile_id
                    union all select 'users'     as type, notes_user.id,      note_type, content, notes_user.add_date, attached, admins.name as admin_name, ad.name as owner from notes_user         left join admins on notes_user.admin_id = admins.id         left join admins ad on ad.id = notes_user.admin_id
                    union all select 'nathriaat' as type, notes_nathriaat.id, note_type, content, notes_nathriaat.add_date, attached, admins.name as admin_name, stakeholders.name as owner from notes_nathriaat left join admins on notes_nathriaat.admin_id = admins.id left join stakeholders on stakeholders.id = notes_nathriaat.nathriaat_id
                ) t " . $search;

        $notes = DB::select($sql);

        $from_date = $request->from_date !== null ? $request->from_date : null;
        $to_date   = $request->to_date !== null ? $request->to_date : null;

        return view('notesDocument.showNotes',
        compact(
            'notes',
            'from_date',
            'to_date'
        ));



    }
    public function getDocuments(Request $request)
    {

        $search = '';
        if($request->has('from_date') && $request->has('to_date')){
            $search = " where date(add_date) >= '".$request->from_date."' and date(add_date) <= '".$request->to_date."';";
        }
        $sql = "select * from
                (
                              select 'drivers'   as type, documents_driver.id,    document_type, content, documents_driver.add_date, attached, admins.name as admin_name, driver.name as owner from documents_driver   left join admins on documents_driver.admin_id = admins.id       left join driver on driver.id = documents_driver.driver_id
                    union all select 'vechiles'  as type, documents_vechile.id,   document_type, content, documents_vechile.add_date, attached, admins.name as admin_name, vechile.plate_number as owner from documents_vechile left join admins on documents_vechile.admin_id = admins.id      left join vechile on vechile.id = documents_vechile.vechile_id
                    union all select 'users'     as type, documents_user.id,      document_type, content, documents_user.add_date, attached, admins.name as admin_name, ad.name as owner from documents_user         left join admins on documents_user.admin_id = admins.id         left join admins ad on ad.id = documents_user.admin_id
                    union all select 'nathriaat' as type, documents_nathriaat.id, document_type, content, documents_nathriaat.add_date, attached, admins.name as admin_name, stakeholders.name as owner from documents_nathriaat left join admins on documents_nathriaat.admin_id = admins.id left join stakeholders on stakeholders.id = documents_nathriaat.nathriaat_id
                ) t " . $search;

        $documents = DB::select($sql);

        $from_date = $request->from_date !== null ? $request->from_date : null;
        $to_date   = $request->to_date !== null ? $request->to_date : null;
        return view('notesDocument.showDocuments',
        compact(
            'documents',
            'from_date',
            'to_date'
        ));


    }
}
