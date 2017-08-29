<?php

namespace App\Repositories\Backend\PartnerManager;

/**
 * Interface UserContract
 * @package App\Repositories\Partner
 */
interface PartnerManagerContract {

    /**
     * @return mixed
     */
    public function allPartnersUser();

    /**
     * @param int $partner_id
     * @param string $name
     * @param string $date_begin
     * @param string $date_end
     * @param int $course_id
     * @param int $studentgroup_id
     * @return array mixed
     */
    public function usersPartnerPerfomance($per_page, $partner_id = null, $name = null, $date_begin = null, $date_end = null, $course_id, $studentgroup = null, &$count_student);

    /**
     * @return mixed
     */
    public function allUsers();

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPartner($id, $order_by = 'id', $sort = 'asc');

    /**
     * @param $id
     * @return mixed
     */
    public function getAllPartnerManagers($id);

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     *
     * @param type $per_page
     * @param type $date_begin
     * @param type $date_end
     * @param type $exam_id
     * @param type $partner_id
     * @param type $name
     * @param type $studentgroup_id
     * @return type array
     */
    public function executionSaap($per_page, $date_begin, $date_end, $exam_id, $partner_id, $name, $studentgroup);

    public function getPerformanceInSaap($per_page, $date_begin, $date_end, $course_id = NULL, $partner_id = NULL, $saap = NULL, $saap_in_lesson = NULL, $proof = NULL, $studentgroup = NULL);
}
