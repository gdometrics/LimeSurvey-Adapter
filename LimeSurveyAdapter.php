<?php

/**
 * LimeSurveyAdapter
 * 
 * This content is released under the The MIT License (MIT)
 *
 * Copyright (c) 2016 Michael Scribellito
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
class LimeSurveyAdapter {

    protected $db;
    protected $prefix = '';

    const TABLE_SURVEY = 'survey_';
    const TABLE_SURVEY_KEY = 'id';
    const TABLE_SURVEYS = 'surveys';
    const TABLE_SURVEYS_KEY = 'sid';
    const TABLE_SURVEYS_LANGUAGESETTINGS = 'surveys_languagesettings';
    const TABLE_SURVEYS_LANGUAGESETTINGS_KEY = 'surveyls_survey_id';

    /**
     * Initializes new LimeSurvey Adapter.
     * 
     * @param array $db database configuration
     * @param type $prefix table prefix
     */
    public function __construct(Array $db, $prefix = '') {

        $this->db = new medoo($db);
        $this->prefix = $prefix;

    }

    /**
     * Returns table name.
     * 
     * @param string $table
     * @return string table name
     */
    protected function getTableName($table) {

        return $this->prefix . $table;

    }

    /**
     * Returns column name.
     * 
     * @param string $column
     * @param string $table
     * @return string column name
     */
    protected function getColumnName($column, $table) {

        return $this->getTableName($table) . '.' . $column;

    }

    /**
     * Returns a list of surveys.
     * 
     * @param boolean $details return details?
     * @return array a list of surveys
     */
    public function getSurveyList($details = false) {

        $from = $this->getTableName(static::TABLE_SURVEYS);
        $join = ['[>]' . $this->getTableName(static::TABLE_SURVEYS_LANGUAGESETTINGS) => [
                static::TABLE_SURVEYS_KEY =>
                static::TABLE_SURVEYS_LANGUAGESETTINGS_KEY]
        ];
        $columns = '*';
        if ($details === false) {
            $columns = [
                $this->getColumnName('sid', static::TABLE_SURVEYS),
                $this->getColumnName('surveyls_title', static::TABLE_SURVEYS_LANGUAGESETTINGS)
            ];
        }

        $data = $this->db->select($from, $join, $columns);

        return $data;

    }

    /**
     * Checks if given survey has been completed.
     * 
     * @param string $survey survey ID
     * @param array $where where clause
     * @return boolean true if given survey has been completed
     */
    public function isCompleted($survey, $where) {

        $table = static::TABLE_SURVEY . $survey;
        $from = $this->getTableName($table);
        $columns = $this->getColumnName(self::TABLE_SURVEY_KEY, $table);

        $data = $this->db->select($from, $columns, $where);

        return count($data) > 0;

    }

}
