#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
#include "arvore.h"



char* leStr(){
    char *chave = malloc(sizeof(char));
    int i = 0;

    setbuf(stdin, NULL);
    while(scanf("%c", &chave[i]) && chave[i] != '\n'){
        setbuf(stdin, NULL);
        i++;
        chave = realloc(chave, (i +1) * sizeof(char));
    }

    chave[i] = '\0';

    return chave;
}


char* preencheAlfabeto(){
    char aux[] = {-96,-95,-94,-93,-89,-87,-86,-83,-77,-76,-75,-70,'$','-','a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '\0'};
    char *alfabeto = malloc(((strlen(aux) + 1 ) * sizeof(char)));
    strcpy(alfabeto, aux);

    return alfabeto;
}

Arvore* preencheArvore(){
    char *alfabeto = NULL, *valor = NULL;

    alfabeto = preencheAlfabeto();

    Arvore *arv = criaArvore(alfabeto);


    FILE *fp = fopen("dicionario.txt", "r");
    char *str = malloc(sizeof(char)), c;
    int len = 1;


    while(!feof(fp)){
        str = realloc(str, len * sizeof(char));
        fscanf(fp, "%c", &c);

        if(!feof(fp) && c != '\n' && c != ' ' && !isdigit(c)){
            str[len-1] = c;
            len++;
        }else if(!feof(fp)){
            str[len-1] = '\0';
            insere(arv, str);
            str = malloc(sizeof(char));
            len = 1;
        }
    }

    if(str)
        free(str);

    fclose(fp);

    return arv;

}

void correcao(char *nomeArq){

    FILE *arqCorrecao = fopen(nomeArq, "r");
    FILE *arqCorrigido = fopen("correcao.txt", "w");

    if(!arqCorrecao)
        return;

    Arvore *arv;
    arv = preencheArvore();

    char *str = malloc(sizeof(char)), c = '0';
    int l = 0, a = 0, quantPalavras = 0, quantPalavrasIncorretas = 0, lenStr = 1, posicao = 0, linha = 1;

    while(!feof(arqCorrecao)){
        a = l = 0;
        fscanf(arqCorrecao, "%c", &c);

        char aux = tolower(c);
        if(c < -97 && lenStr > 1 && str[lenStr-2] == -61)
            aux += 32;


        if(!feof(arqCorrecao) && !isdigit(c) && (c == -61 || buscaPosicaoDicionario(arv->alfabeto, aux, 0, strlen(arv->alfabeto)) != -1)){
            str[lenStr-1] = c;
            str = realloc(str, ++lenStr * sizeof(char));
        }else{
            if(lenStr > 2){
                str[lenStr-1] = '\0';

                buscaDigital(arv, arv->raiz, str, &l, &a);

                if(!a){ // palavra incorreta
                    fwrite(str, sizeof(char), lenStr-1, arqCorrigido);
                    quantPalavrasIncorretas++;
                    fprintf(arqCorrigido, "*%i*", linha);
                }

                quantPalavras++;
            }

            lenStr = 1;
            free(str);
            str = malloc(sizeof(char));
            if(c == '\n')
                linha++;
        }

    }

    free(str);

    desalocaArvore(arv);

    fclose(arqCorrigido);
    fclose(arqCorrecao);

    FILE *erro = fopen("porcentagemErro.txt", "w");
    float porcentagemErro = 0;

    if(quantPalavras != 0)
        porcentagemErro = (quantPalavrasIncorretas * 100.0) / quantPalavras;

    fprintf(erro, "%.2f", porcentagemErro);

    fclose(erro);
}


int main(){
    char *arq = malloc(13 * sizeof(char));
    strcpy(arq, "corrigir.txt");

    correcao(arq);

    free(arq);

    return 0;
}