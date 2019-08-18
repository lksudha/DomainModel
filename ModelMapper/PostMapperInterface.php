<?php


namespace ModelMapper;


interface PostMapperInterface
{
    public function findById($id);
    public function findAll(array $conditions = array());

    public function insert(PostInterface $post);
    public function delete($id);
}