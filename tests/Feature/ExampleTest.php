<?php

describe('sum', function () {
    it('may sum integers', function () {
        $result = 1 + 2;

        expect($result)->toBeint()->toBe(3);
    });

    it('may sum floats', function () {
        $result = 1.5 + 2.5;

        expect($result)->toBeFloat()->toBe(4.0);
    });
});
