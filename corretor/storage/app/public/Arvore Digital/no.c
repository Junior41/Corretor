#include <stdio.h>
#include <stdlib.h>
#include "no.h"

No *criaNo(int lenAlfabeto){
    No *no = malloc(sizeof(No));
    no->terminal = 0;
    no->filhos = malloc((lenAlfabeto + 1) * sizeof(No*));

    for(int i = 0; i < lenAlfabeto; i++)
        no->filhos[i] = NULL;

    return no;
}


void desalocaNo(No *no){
    free(no->filhos);
    free(no);
}

void desalocaNos(No *no, int len){
    for(int i = 0; i < len; i++){
        if(no->filhos[i])
            desalocaNos(no->filhos[i], len);
    }

    desalocaNo(no);
}