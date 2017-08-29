<?php

namespace App\Repositories\Backend\Order;

use App\Coupon;
use App\Course;
use App\CourseAggregatedCourse;
use App\CourseTeacher;
use App\Enrollment;
use App\CourseAggregatedExam;
use App\ExamPackage;
use App\MyWorkshopTutor;
use App\Order;
use App\Package;
use App\Transaction;
use App\User;
use App\Workshop;
use App\WorkshopCriteria;
use App\WorkshopEvaluationGroup;
use App\WorkshopGroupTutor;
use App\WorkshopTutor;
use Carbon\Carbon;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentOrderRepository implements OrderContract {
//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {

        $order = Order::withTrashed()->find($id);

        if (!is_null($order)) {
            return $order;
        } else {
            throw new GeneralException('Desculpe-nos! Pedido não encontrato. ID: ' . $id);
        }
    }

    /**
     * Função para deletar todos os pedidos de usuários do brasil jurídico
     *
     */
    public function deleteOrdersBrasilJuridico() {
        //Busca por usuários do brasil jurídico
        $users = User::where('users.email', 'like', '%brasiljuridico%')
                ->orWhere('users.email', 'like', '%franciscofontenele.fonte@gmail.com%')
                ->orWhere('users.email', 'like', '%adhemarfontes@gmail.com%')
                ->lists('users.id');

        //Percorre os usuário e faz a busca na tabela de pedidos, passando como parâmetro o id do usuário
        //E muda o status do pedido para 5
        foreach ($users as $user) {
            $orders = Order::query()->where('orders.student_id', '=', $user)->get();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $order->status_id = 5;
                    $order->save();
                }
            }
        }
    }

    /**
     * @param int $per_page
     * @param string $date_begin
     * @param string $date_end
     * @param int $id
     * @param string $status
     * @param string $withUser
     * @param string $withoutEnrollment
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOrdersPaginated($per_page, $date_begin, $date_end, $id, $status, $withUser, $withoutEnrollment, $only_paid, $order_by = '', $sort = '') {
        $query = Order::whereNotNull('orders.id')
                ->whereNotNull('orders.student_id');

        if (isset($id) && $id != "")
            $query->where('orders.id', '=', $id);

        if (isset($status) && $status != "")
            $query->where('orders.status_id', '=', $status);

        if (isset($withUser) && $withUser == 1)
            $query->whereNotNull('orders.student_id');

        if (isset($date_begin) && $date_begin != "")
            $query->where('orders.date_registration', '>=', parsebr($date_begin));

        if (isset($date_begin) && $date_end != "")
            $query->where('orders.date_registration', '<', parsebr($date_end)->addDay());

        if ($order_by == '') {
            $query->orderBy('orders.date_registration', 'asc')->orderBy('orders.id', 'asc');
        } else {
            $query->orderBy($order_by, $sort)->orderBy('orders.id', 'asc');
        }


        if (isset($only_paid) && !empty($only_paid))
            $query->whereRaw('orders.discount_price > 0.00');

        //Se foi selecionados os liberados sem matrícula
        if (isset($withoutEnrollment) && !empty($withoutEnrollment) && $status == '4') {
            $orders = $query->get();
            $results = null;
            foreach ($orders as $order) {
                $enrollment = Enrollment::where('order_id', '=', $order->id)->get();
                if (count($enrollment) <= 0) {
                    $results[] = $order;
                }
            }
            //Fazendo uma nova coleção
            $results = new Collection($results);

            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            //Slice the collection to get the items to display in current page
            $currentPageItems = $results->slice(($currentPage - 1) * $per_page, $per_page);

            return new LengthAwarePaginator(
                    $currentPageItems, count($results), $per_page, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]
            );
        }
        return $query->paginate($per_page);
    }

    public function getOrdersForPayment($datebegin, $dateend = null) {
        if ($dateend == null)
            $dateend = $datebegin;

        $query = Order::where('status_id', '=', 4);
        $query->where('date_confirmation', '>=', parsebr($datebegin));
        $query->where('date_confirmation', '<', parsebr($dateend)->addDay());
        return $query->orderBy('id', 'asc')->get();
    }

    public function getOrdersStudent($user_id, $order_by = 'id', $sort = 'desc') {
        return Order::where('student_id', '=', $user_id)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedOrdersPaginated($per_page) {
        return Order::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $date_begin
     * @param string $date_end
     * @param string $id
     * @param string $status
     * @param string $withoutEnrollment
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOrders($date_begin, $date_end, $id, $status, $withoutEnrollment, $order_by = 'id', $sort = 'asc') {
        $query = Order::whereNotNull('id');
        if (isset($id) && $id != "")
            $query->where('id', '=', $id);

        if (isset($status) && $status != "")
            $query->where('status_id', '=', $status);

        if (isset($date_begin) && $date_begin != "")
            $query->where('date_registration', '>=', parsebr($date_begin));

        if (isset($date_begin) && $date_end != "")
            $query->where('date_registration', '<', parsebr($date_end)->addDay());

        if ($order_by == '') {
            $query->orderBy('date_registration', 'asc')->orderBy('id', 'asc');
        } else {
            $query->orderBy($order_by, $sort)->orderBy('id', 'asc');
        }

        //Se foi selecionados os liberados sem matrícula
        if (!empty($withoutEnrollment) && $status == '4') {
            $orders = $query->get();
            $results = null;
            foreach ($orders as $order) {
                $enrollment = Enrollment::where('order_id', '=', $order->id)->get();
                if (count($enrollment) <= 0) {
                    $results[] = $order;
                }
            }
            return new Collection($results);
        }

        return $query->get();
    }

    /**
     * @param string $term
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function selectOrders($term = '', $order_by = 'name', $sort = 'asc') {
        return Order::where('name', 'like', $term . '%')->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $order = $this->createOrderStub($input);
        if ($order->save())
            return true;
        throw new GeneralException('There was a problem creating this order. Please try again.');
    }

    /**
     * @param array $orders
     * @return bool
     * @throws GeneralException
     * @internal param $input
     */
    public function createIfNew(array $orders) {

        foreach ($orders as $order) {
            $model = Order::firstOrNew(['name' => $order]);
            $model->name = $order;
            $model->save();
        }
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $order = $this->findOrThrowException($id);

        if ($order->update($input)) {
            $order->name = $input['name'];
            $order->description = $input['description'];
            $order->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this order. Please try again.');
    }

    /**
     * @param $id
     * @param $total
     * @return bool
     * @throws GeneralException
     */
    public function updateTotalById($id, $total) {
        $order = $this->findOrThrowException($id);
        $order->price = $total;
        $order->discount_price = $total - session('discount');
        if ($order->discount_price < 0) {
            $order->discount_price = 0;
        }
        if ($order->save())
            return $order;

        throw new GeneralException('There was a problem updating this order. Please try again.');
    }

    /**
     * @param $id
     * @param $student_id
     * @return bool
     * @throws GeneralException
     */
    public function updateStudentById($id, $student_id) {
        $order = $this->findOrThrowException($id);
        $order->student_id = $student_id;
        if ($order->save())
            return $order;

        throw new GeneralException('There was a problem updating this order. Please try again.');
    }

    /**
     * @return bool
     * @throws GeneralException
     */
    public function storeByCartAdd($total) {
        $order = new Order;
        $order->status_id = 1;
        $order->date_registration = Carbon::now();
        $order->price = $total;
        $order->discount_price = $total - session('discount');
        if ($order->save()) {
            return $order;
        }
        throw new GeneralException('There was a problem storing this order. Please try again.');
    }

    /**
     * @param $coupon_code
     * @param $order_id
     * @return mixed
     * @throws GeneralException
     */
    public function assignCouponToOrder($coupon_code, $order_id) {

        if (!$order_id)
            throw new GeneralException('Não foi possível associar o cupom a compra.');

        $coupon = Coupon::where('code', $coupon_code)->first();

        if (!$coupon)
            throw new GeneralException('Cupom não encontrado.');

        $order = Order::find($order_id);

        if (count($order) > 0) {
            if (count($order) > 0) {
                $order->coupon_id = $coupon->id;
            }

            if (!$order->save())
                throw new GeneralException('Desculpe, tivemos dificuldades para utilizar seu cupom. Por favor, tente novamente.');
        }else {
            throw new GeneralException('Desculpe, tivemos dificuldades para utilizar seu cupom. Por favor, tente novamente. (Pedido:' . $order_id . ')');
        }
    }

    /**
     * REFATORAR REFATORAR REFATORAR REFATORAR REFATORAR
     * REFATORAR           REFATORAR           REFATORAR
     * REFATORAR REFATORAR REFATORAR REFATORAR REFATORAR
     * 
     * Status do feedback pag seguro
     *
      1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
      2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
      3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
      4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
      5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
      6	Devolvida: o valor da transação foi devolvido para o comprador.
      7	Cancelada: a transação foi cancelada sem ter sido finalizada.
     */
    public function updateFromPagseguroFeedback($dataXml) {

        $order = Order::find($dataXml->reference);

        if (isset($dataXml->code)) {
            $transaction = new Transaction;
            $transaction->order_id = $dataXml->reference;
            $transaction->payment_hub = 'pagseguro';
            $transaction->payment_id = $dataXml->code;
            $transaction->payment_method = $dataXml->paymentMethod->type;
            $transaction->payment_code = $dataXml->paymentMethod->code;
            $transaction->installment_fee_amount = $dataXml->installmentFeeAmount;
            $transaction->installment_count = $dataXml->installmentCount;
            $transaction->discount_amount = $dataXml->discountAmount;
            $transaction->status_id = $dataXml->status;
            $transaction->gross_amount = $dataXml->grossAmount;
            $transaction->net_amount = $dataXml->netAmount;
            $transaction->operational_fee_amount = $dataXml->operationalFeeAmount;
            $transaction->intermediation_fee_amount = $dataXml->intermediationFeeAmount;
            $transaction->intermediation_fee_rate = $dataXml->intermediationRateAmount;
            $transaction->escrow_date = $dataXml->escrowEndDate;
            $transaction->save();
        }

        // Avoid repeated access to this section
        if ($order->status_id == 4 && $dataXml->status == 3)
            return false;

        //Mocking order id 5
        //$order = Order::find(5);
        //Mocking status 5
        //$dataXml->status = 5;

        if (in_array($dataXml->status, [3, 4]) && $order->status_id != 4) {
            $order->status_id = 4;

            if (count($order->courses) > 0) {
                // Increment orders count in courses
                //Course::whereIn('id', $order->courses->lists('course_id'))->update(['orders_count' => \DB::raw('orders_count + 1')]);
                // Increment orders count in teachers
                $teachers = CourseTeacher::whereIn('course_id', $order->courses->lists('course_id'))->lists('teacher_id');
                User::whereIn('id', $teachers)->update(['orders_count' => \DB::raw('orders_count + 1')]);

                $items = Course::whereIn('id', $order->courses->lists('course_id'))->get();

                $this->createEnrollment($items, $order, 'course');
            }
            if (count($order->packages) > 0) {
                $items = ExamPackage::whereIn('package_id', $order->packages->lists('package_id'))->get();
                $this->createEnrollment($items, $order, 'package');
            }
        }

        if (in_array($dataXml->status, [5, 6, 7])) {
            $order->status_id = 5;

            // Disable enrollments
            $enrollments = Enrollment::where('order_id', $order->id)->get();
            if (count($enrollments) > 0) {
                foreach ($enrollments as $enrollment) {
                    $enrollment->is_active = 0;
                    $enrollment->save();
                }
            }
        }

        if ($order->date_confirmation == null) {
            $order->date_confirmation = Carbon::now();
        }

        if (in_array($dataXml->status, [1, 2]))
            $order->status_id = 2;


        $order->save();
    }

    private function createEnrollment($items, $order, $type) {

        foreach ($items as $item) {
            //dont create more than one enrollment for a free item
            if ($order->discount_price == 0.00) {

                if ($type == 'course')
                    $enrollments = Enrollment::where("student_id", "=", $order->student_id)->where("course_id", "=", $item->id)->where("is_active", "=", 1)->get();
                if ($type == 'package')
                    $enrollments = Enrollment::where("student_id", "=", $order->student_id)->where("exam_id", "=", $item->exam_id)->where("is_active", "=", 1)->get();

                if (($enrollments != null) && (count($enrollments) != 0)) {
                    return;
                }
            }

            $enrollment = new Enrollment;
            $enrollment->order_id = $order->id;
            $enrollment->student_id = $order->student_id;

            if ($type == 'course')
                $enrollment->course_id = $item->id;
            if ($type == 'package')
                $enrollment->exam_id = $item->exam_id;

            $enrollment->date_begin = Carbon::now();

            if ($type == 'course')
                $enrollment->date_end = Carbon::now()->addDays($item->access_time);
            if ($type == 'package')
                $enrollment->date_end = Carbon::now()->addDays($item->package->access_time);

            if ($type == 'package')
                $enrollment->exam_max_tries = $item->exam->max_tries;

            $enrollment->is_active = 1;
            if ($type == 'course') {
                $course = Course::find($item->id);
                //não ativar matricula para curso do tipo combo
                if ($course->combo == 1) {
                    $enrollment->is_active = 0;
                }
            }

            $enrollment->is_paid = 1;
            $enrollment->save();

            $original_enrollment = $enrollment->id;

            if ($type == 'course') {
                $item->orders_count = $item->orders_count + 1;
                $item->save();
            }

            if ($type == 'course') {
                $this->associateTutorForWorkshop($enrollment);
            }

            if ($type == 'course') {
                $courses_extra = CourseAggregatedCourse::where('course_id_bought', '=', $item->id)->get();
                foreach ($courses_extra as $course_extra) {
                    $enrollment = new Enrollment;
                    $enrollment->order_id = $order->id;
                    $enrollment->student_id = $order->student_id;
                    $enrollment->course_id = $course_extra->course_id_extra;
                    $enrollment->date_begin = Carbon::now();
                    $enrollment->date_end = Carbon::now()->addDays($item->access_time);
                    $enrollment->is_active = 1;
                    $enrollment->is_paid = 1;
                    $enrollment->course_enrollment_id = $original_enrollment;
                    $enrollment->save();

                    $this->associateTutorForWorkshop($enrollment);

                    $course_extra->course_extra->orders_count = $course_extra->course_extra->orders_count + 1;
                    $course_extra->course_extra->save();
                }

                $courses_extra = CourseAggregatedExam::where('course_id_bought', '=', $item->id)->get();
                foreach ($courses_extra as $course_extra) {
                    $enrollment = new Enrollment;
                    $enrollment->order_id = $order->id;
                    $enrollment->student_id = $order->student_id;
                    $enrollment->exam_id = $course_extra->exam_id_extra;
                    if ($course_extra->date_begin != null){
                        $enrollment->date_begin = $course_extra->date_begin;
                    } else if (($course_extra->days_begin != null) && ($course_extra->days_begin != 0)) {
                        $enrollment->date_begin = Carbon::now();
                        $enrollment->date_begin->addDay( $course_extra->days_begin );
                    } else {
                        $enrollment->date_begin = Carbon::now();
                    }
                    $enrollment->date_end = Carbon::now()->addDays($item->access_time);
                    $enrollment->exam_max_tries = $course_extra->course_extra->max_tries;
                    $enrollment->is_active = 1;
                    $enrollment->is_paid = 1;
                    $enrollment->course_enrollment_id = $original_enrollment;
                    $enrollment->save();

                    $course_extra->save();
                }
            }
        }
    }

    private function associateTutorForWorkshop($enrollment) {
        $workshops = Workshop::where("course_id", "=", $enrollment->course_id)->get();
        if (count($workshops) == 0) {
            return;
        }

        $pending = false;

        foreach ($workshops as $workshop) {
            $criterias = WorkshopCriteria::where('workshop_id', '=', $workshop->id)->get();

            $groups = WorkshopEvaluationGroup::where('workshop_id', '=', $workshop->id)->
                            whereRaw('workshop_evaluation_groups.num_students < workshop_evaluation_groups.max_students')->
                            orderBy('position', 'asc')->get();
            if (count($groups) != 0) {
                $group = $groups[0];

                $tutors = WorkshopGroupTutor::where('workshop_evaluation_group_id', '=', $group->id)->get();
                if (count($tutors) != 0) {
                    foreach ($tutors as $tutor) {
                        foreach ($criterias as $criteria) {
                            $mytutor = new MyWorkshopTutor();
                            $mytutor->workshop_id = $workshop->id;
                            $mytutor->criteria_id = $criteria->id;
                            $mytutor->tutor_id = $tutor->tutor_id;
                            $mytutor->enrollment_id = $enrollment->id;
                            $mytutor->activity_id = $tutor->activity_id;
                            $mytutor->save();
                        }
                    }
                } else {
                    $pending = true;
                }

                $group->num_students = $group->num_students + 1;
                $group->save();
            } else {
                foreach ($criterias as $criteria) {
                    $tutors = WorkshopTutor::where('workshop_id', '=', $workshop->id)->
                                    where('criteria_id', '=', $criteria->id)->
                                    whereRaw('workshop_tutors.num_students < workshop_tutors.max_students')->
                                    orderBy('position', 'asc')->get();
                    if (count($tutors) != 0) {
                        $tutor = $tutors[0];
                        $mytutor = new MyWorkshopTutor();
                        $mytutor->workshop_id = $workshop->id;
                        $mytutor->criteria_id = $criteria->id;
                        $mytutor->tutor_id = $tutor->tutor_id;
                        $mytutor->enrollment_id = $enrollment->id;
                        $mytutor->save();

                        $tutor->num_students = $tutor->num_students + 1;
                        $tutor->save();
                    } else {
                        $pending = true;
                    }
                }
            }
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $order = $this->findOrThrowException($id);

        if ($order->delete()) {
            return true;
        }

        throw new GeneralException("There was a problem deleting this order. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createOrderStub($input) {
        $order = new Order;
        $order->name = $input['name'];
        $order->description = $input['description'];
        return $order;
    }

    public function deactivated($id) {
        $order = $this->findOrThrowException($id);
        $order->active_at = null;
        $order->user_moderator_id = auth()->user()->id;
        $order->save();
        return true;

        throw new GeneralException('There was a problem updating this order. Please try again.');
    }

    public function activated($id) {
        $order = $this->findOrThrowException($id);
        $order->status_id = 4;
        $order->date_confirmation = Carbon::now();
        $order->save();
        return true;

        throw new GeneralException('There was a problem updating this order. Please try again.');
    }

    /**
     * @param $coupon_code
     * @param $order_id
     * @return mixed
     * @throws GeneralException
     */
    public function assignPartnerToOrder($partner_id, $order_id) {
        if (!$order_id)
            throw new GeneralException('Não foi possível associar o conveniado a compra.');

        $order = Order::find($order_id);
        $order->partner_id = $partner_id;

        if (!$order->save())
            throw new GeneralException('There was a problem assign a coupon to an order. Please try again.');
    }

}
