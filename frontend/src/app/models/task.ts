export class Task{
    constructor(
        public id: number,
        public user_id: number,
        public etiqueta_id: number,
        public description: string,
        public estado: number
    ){}
}